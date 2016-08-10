<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToManyField;
use Bozboz\Admin\Reports\Filters\ArrayListingFilter;
use Bozboz\Admin\Reports\Filters\RelationFilter;
use Html;

class MMCategories extends Presenter
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
            'Categories' => $instance->categories->pluck('name')->implode(', '),
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new BelongsToManyField(
                $this->categoryDecorator,
                $instance->categories()
            ),
        ]);
    }

    public function getListingFilters($model)
    {
        return array_merge($this->presenter->getListingFilters($model), [
            new ArrayListingFilter(
                'Category',
                ['' => 'All'] + $this->getCategoryOptions($model->categories()->getRelated()->withDepth()->get()->toTree()),
                function($query, $categoryId) {
                    $category = $this->categoryDecorator->findInstance ($categoryId);
                    $query->where(function($query) use ($category) {
                        $query->whereHas('categories', function($query) use ($category) {
                            $query->whereBetween('_lft', [$category->_lft, $category->_rgt]);
                        });
                        $query->orWhereHas('variationOf', function($query) use ($category) {
                            $query->whereHas('categories', function($query) use ($category) {
                                $query->whereBetween('_lft', [$category->_lft, $category->_rgt]);
                            });
                        });
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

    public function getSyncRelations()
    {
        return array_merge($this->presenter->getSyncRelations(), [
            'categories'
        ]);
    }
}