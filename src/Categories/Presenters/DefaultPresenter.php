<?php

namespace Bozboz\Ecommerce\Products\Categories\Presenters;

use Bozboz\Admin\Fields\CheckboxField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Fields\URLField;
use Bozboz\Admin\Reports\Filters\SearchListingFilter;
use Bozboz\Ecommerce\Products\Presenters\Presentable;
use HTML;

class DefaultPresenter implements Presentable
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
        $path = $instance->getAncestors()->pluck('slug')->filter()->push($instance->slug)->implode('/');
        return [
            'Name' => $instance->name . '&nbsp;&nbsp;&nbsp;'
                . HTML::decode(HTML::linkRoute($this->route, '<i class="fa fa-external-link"></i>', $path))
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
