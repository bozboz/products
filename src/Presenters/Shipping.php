<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Fields\TextField;

class Shipping extends Presenter
{
    private $shipping;

    public function __construct($shipping, Presentable $presenter)
    {
        $this->shipping = $shipping;

        parent::__construct($presenter);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new BelongsToField($this->shipping, $instance->shippingBand()),
            new TextField('weight'),
        ]);
    }
}