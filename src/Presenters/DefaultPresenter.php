<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\CheckboxField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Reports\Filters\SearchListingFilter;
use Bozboz\Ecommerce\Products\Presenters\Fields\ProductURLField;

class DefaultPresenter implements Presentable
{
    private $route;

    public function __construct($route = null)
    {
        $this->route = $route;
    }

    public function getLabel($instance)
    {
        return $instance->name;
    }

    public function getColumns($instance)
    {
        return [
            'ID' => sprintf('<strong>#%s</strong>', str_pad($instance->id, 3, '0', STR_PAD_LEFT)),
            'Name' => $instance->name,
            'Status' => $instance->status ? '<i class="fa fa-check"></i>' : '<i class="fa fa-cross"></i>',
            'Added' => $instance->created_at ? sprintf('<abbr title="%s">%s</a>',
                $instance->created_at->format('jS F Y'),
                $instance->created_at->diffForHumans()
            ) : null
        ];
    }

    public function getFields($instance)
    {
        return [
            new TextField('name'),
            $this->route && method_exists('category', $instance) ? new ProductURLField('slug', [
                'route' => $this->route,
                'data-auto-slug-from' => $instance->getSlugSourceField()
            ]) : new TextField('slug'),
            new CheckboxField('status'),
        ];
    }

    public function getListingFilters($model)
    {
        return [
            new SearchListingFilter('search', function($builder, $value) {
                $builder->where(function ($query) use ($value) {
                    $attributes = ['sku', 'name'];
                    foreach ($attributes as $attribute) {
                        $query->orWhere($attribute, 'LIKE', '%' . $value . '%');
                    }
                    $query->orWhereHas('variants', function($query) use ($attributes, $value) {
                        foreach ($attributes as $attribute) {
                            $query->orWhere($attribute, 'LIKE', '%' . $value . '%');
                        }
                    });
                });
            })
        ];
    }

    public function getSyncRelations()
    {
        return [];
    }
}
