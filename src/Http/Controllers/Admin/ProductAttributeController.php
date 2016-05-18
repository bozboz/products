<?php

namespace Bozboz\Ecommerce\Products\Http\Controllers\Admin;

use Bozboz\Admin\Http\Controllers\ModelAdminController;
use Bozboz\Ecommerce\Products\Attributes\AttributeDecorator;

class ProductAttributeController extends ModelAdminController
{
    public function __construct(AttributeDecorator $decorator)
    {
        parent::__construct($decorator);
    }
}
