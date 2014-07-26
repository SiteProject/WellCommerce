<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Core\DataGrid;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Loader\LoaderInterface;
use WellCommerce\Core\DataGrid\Options\OptionsInterface;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Core\DataGrid\Request\Request;
use WellCommerce\Core\DataGrid\Request\RequestInterface;
use WellCommerce\Core\Repository\RepositoryInterface;
use xajaxResponse;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Core\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractComponent
{
    /**
     * @var \WellCommerce\Core\DataGrid\Column\ColumnCollection
     */
    protected $columns;
    protected $identifier;
    protected $repository;
    protected $loader;
    protected $options;
    protected $queryBuilder;
    protected $container;
    protected $request;

    /**
     * Constructor
     *
     * @param ContainerInterface  $container
     * @param RepositoryInterface $repository
     * @param LoaderInterface     $loader
     */
    public function __construct(ContainerInterface $container, RepositoryInterface $repository, LoaderInterface $loader)
    {
        $this->container  = $container;
        $this->repository = $repository;
        $this->loader     = $loader;
    }

    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setOptions(OptionsInterface $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueryBuilder(QueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($datagridId)
    {
        $objResponse = new xajaxResponse();
        $objResponse->script('' . 'try {' . 'GF_Datagrid.ReturnInstance(' . (int)$datagridId . ').LoadData();' . '}' . 'catch (xException) {' . 'GF_Debug.HandleException(xException);' . '}' . '');

        return $objResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRow($request)
    {
        try {
            $this->repository->updateDataGridRow($request);

        } catch (ValidatorException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($request)
    {
        return $this->repository->delete($request['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options)
    {
        $this->setCurrentRequest(new Request([
            'id'            => $options['id'],
            'starting_from' => (int)$options['starting_from'],
            'limit'         => (int)$options['limit'],
            'order_by'      => $options['order_by'],
            'order_dir'     => $options['order_dir'],
            'where'         => $options['where']
        ]));

        return $this->loader->getResults($this);
    }


}