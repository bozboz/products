<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\RelationField;
use Bozboz\Admin\Reports\Filters\RelationFilter;

class Attributes extends Presenter
{
    private $attributes;

    public function __construct($attributes, Presentable $presenter)
    {
        $this->attributes = $attributes;

        parent::__construct($presenter);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new BelongsToManyField(
                $this->attributes, $instance->attributeOptions(), [ 'label' => 'Attributes' ], function($query) {
                    $query->with('attribute')->orderBy('product_attribute_id')->orderBy('value');
                }
            )
        ]);
    }
}