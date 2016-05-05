<?php

namespace Bozboz\Ecommerce\Products\Http\Controllers\Admin;

use Bozboz\Admin\Http\Controllers\ModelAdminController;
use Bozboz\Ecommerce\Products\ProductDecorator;

class ProductController extends ModelAdminController
{
    protected $useActions = true;

    public function __construct(ProductDecorator $decorator)
    {
        parent::__construct($decorator);
    }
}
