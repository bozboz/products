<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Fields\TreeSelectField;
use Bozboz\Admin\Reports\Filters\ArrayListingFilter;
use Bozboz\Admin\Reports\Filters\RelationFilter;
use Html;

class Categories extends Presenter
{
    private $categoryDecorator;

    public function __construct($categoryDecorator, Presentable $presenter)
    {
        $this->categoryDecorator = $categoryDecorator;

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
            new ArrayListingFilter(
                'Category',
                ['' => 'All'] + $this->getCategoryOptions($model->category()->getRelated()->withDepth()->get()->toTree()),
                function($query, $categoryId) {
                    $category = $this->categoryDecorator->findInstance ($categoryId);
                    $query->whereHas('category', function($query) use ($category) {
                        $query->whereBetween('_lft', [$category->_lft, $category->_rgt]);
                    });
                }
            ),
        ]);
    }

    public function getCategoryOptions($tree, $options = [])
    {
        foreach ($tree as $category) {
            $options[$category->id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->depth) . $category->name;
            $options = $this->getCategoryOptions($category->children, $options);
        }
        return $options;
    }
}