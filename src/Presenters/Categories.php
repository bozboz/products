<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Reports\Filters\RelationFilter;
use Html;

class Categories extends Presenter
{
    private $categories;

    public function __construct($categories, Contract $presenter)
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
            new BelongsToField(
                $this->categories, $instance->category(), ['label' => 'Category']
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