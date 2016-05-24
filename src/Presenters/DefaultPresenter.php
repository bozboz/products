<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\CheckboxField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Fields\URLField;
use Bozboz\Admin\Reports\Filters\SearchListingFilter;

class DefaultPresenter implements Contract
{
    private $route;

    public function __construct($route)
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
            new URLField('slug', ['route' => $this->route, 'data-auto-slug-from' => $instance->getSlugSourceField()]),
            new CheckboxField('status'),
        ];
    }

    public function getListingFilters($model)
    {
        return [
            new SearchListingFilter('search', ['sku', 'name'])
        ];
    }

    public function getSyncRelations()
    {
        return [];
    }
}
