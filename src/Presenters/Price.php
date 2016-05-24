<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use Bozboz\Admin\Fields\CheckboxField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Ecommerce\Products\Pricing\PriceField;

class Price extends Presenter
{
    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Price' => format_money($instance->price_pence),
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [
            new PriceField('price', ['label' => 'Base Price']),
        ]);
    }
}
