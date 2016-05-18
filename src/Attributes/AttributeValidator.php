<?php

namespace Bozboz\Ecommerce\Products\Attributes;

use Bozboz\Admin\Services\Validators\Validator;

class AttributeValidator extends Validator
{
	protected $rules = [
		'name' => 'required'
	];
}