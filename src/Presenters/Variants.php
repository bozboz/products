<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use HTML;

class Variants extends Presenter
{
    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Variants' => $instance->variants->count(),
        ]);
    }
}