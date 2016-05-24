<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToManyField;

class Related extends Presenter
{
    private $products;

    public function __construct($products, Contract $presenter)
    {
        $this->products = $products;
        parent::__construct($presenter);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new BelongsToManyField(
                $this->products, $instance->relatedProducts(), ['label' => 'Related Products'], function($query) {
                    $query->visible();
                }
            )
        ]);
    }

    public function getSyncRelations()
    {
        return array_merge($this->presenter->getSyncRelations(), ['relatedProducts']);
    }
}