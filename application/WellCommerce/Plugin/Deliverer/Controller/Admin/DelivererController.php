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
namespace WellCommerce\Plugin\Deliverer\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Deliverer\Repository\DelivererRepositoryInterface;

/**
 * Class DelivererController
 *
 * @package WellCommerce\Plugin\Deliverer\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('deliverer.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('deliverer.form'), null, [
            'name' => 'add_deliverer'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat());

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('deliverer.form'), $model, [
            'name' => 'edit_deliverer'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat(), $id);

            if ($form->isAction('continue')) {
                return $this->redirect($this->generateUrl('admin.deliverer.edit', ['id' => $model->id]));
            }

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'deliverer' => $model,
            'form'      => $form
        ];
    }

    /**
     * Sets deliverer repository object
     *
     * @param DelivererRepositoryInterface $repository
     */
    public function setRepository(DelivererRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
