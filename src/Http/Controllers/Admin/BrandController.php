<?php

namespace Bozboz\Ecommerce\Products\Http\Controllers\Admin;

use Bozboz\Admin\Http\Controllers\ModelAdminController;
use Bozboz\Ecommerce\Products\Brands\BrandDecorator;

class BrandController extends ModelAdminController
{
    protected $useActions = true;

    public function __construct(BrandDecorator $decorator)
    {
        parent::__construct($decorator);
    }
}
