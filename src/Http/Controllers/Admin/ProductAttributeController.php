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
