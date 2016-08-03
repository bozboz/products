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

    public function viewPermissions($stack)
    {
        $stack->add('ecommerce');
    }

    public function createPermissions($stack, $instance)
    {
        $stack->add('ecommerce', $instance);
    }

    public function editPermissions($stack, $instance)
    {
        $stack->add('ecommerce', $instance);
    }

    public function deletePermissions($stack, $instance)
    {
        $stack->add('ecommerce', $instance);
    }
}
