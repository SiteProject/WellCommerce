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
namespace WellCommerce\Bundle\CouponBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Sorting;

/**
 * Class CouponDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('coupon.label.id'),
            'sorting'    => new Sorting([
                'default_order' => Sorting::SORT_DIR_DESC,
            ]),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'name',
            'caption' => $this->trans('coupon.label.name'),
        ]));

        $collection->add(new Column([
            'id'      => 'code',
            'caption' => $this->trans('coupon.label.code'),
        ]));

        $collection->add(new Column([
            'id'      => 'discount',
            'caption' => $this->trans('coupon.label.discount'),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('coupon.label.created_at'),
        ]));

        $collection->add(new Column([
            'id'      => 'validFrom',
            'caption' => $this->trans('coupon.label.valid_from'),
        ]));

        $collection->add(new Column([
            'id'      => 'validTo',
            'caption' => $this->trans('coupon.label.valid_to'),
        ]));
    }
}
