<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Fields\TreeSelectField;
use Bozboz\Admin\Reports\Filters\RelationFilter;
use Html;

class Categories extends Presenter
{
    private $categories;

    public function __construct($categories, Presentable $presenter)
    {
        $this->categories = $categories;

        parent::__construct($presenter);
    }

    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Category' => $instance->category ? $instance->category->name : '',
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new TreeSelectField(
                $instance->category()->getRelated()->all(),
                ['label' => 'Category', 'name' => $instance->category()->getForeignKey()]
            ),
        ]);
    }

    public function getListingFilters($model)
    {
        return array_merge($this->presenter->getListingFilters($model), [
            new RelationFilter($model->category(), $this->categories),
        ]);
    }
}