<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Reports\Filters\RelationFilter;

class Brand extends Presenter
{
    private $brands;

    public function __construct($brands, Presentable $presenter)
    {
        $this->brands = $brands;
        parent::__construct($presenter);
    }

    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Brand' => $instance->brand ? $instance->brand->name : '',
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new BelongsToField($this->brands, $instance->brand()),
        ]);
    }

    public function getListingFilters($model)
    {
        return array_merge($this->presenter->getListingFilters($model), [
            new RelationFilter($model->brand(), $this->brands),
        ]);
    }
}
