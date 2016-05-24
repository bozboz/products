<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\RelationField;
use Bozboz\Admin\Reports\Filters\RelationFilter;

class Attributes extends Presenter
{
    private $attributes;

    public function __construct($attributes, Contract $presenter)
    {
        $this->attributes = $attributes;

        parent::__construct($presenter);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new RelationField($instance->attributes(), $this->attributes),
        ]);
    }
}