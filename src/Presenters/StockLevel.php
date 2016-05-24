<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Reports\Filters\ArrayListingFilter;

class StockLevel extends Presenter
{
    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Stock Level' => $instance->exists ? (count($instance->variants) ? '-' : $instance->stock_level) : null,
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new TextField('stock_level'),
        ]);
    }

    public function getListingFilters($model)
    {
        return array_merge($this->presenter->getListingFilters($model), [
            new ArrayListingFilter('stock_level', $this->getStockLevelList(), function($builder, $value){
                switch ($value) {
                    case 'in_stock':
                        $builder->where('stock_level', '>', 0);
                    break;

                    case 'out_of_stock':
                        $builder->where(function($q){
                            $q->whereNull('stock_level')
                              ->orWhere('stock_level', '=', 0);
                        });
                    break;
                }
            }),
        ]);
    }

    private function getStockLevelList()
    {
        return [
            null => 'All',
            'out_of_stock' => 'Out of stock only',
            'in_stock' => 'In stock only',
        ];
    }
}