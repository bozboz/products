<?php

namespace Bozboz\Ecommerce\Products\Attributes\Options;

use Bozboz\Admin\Services\Validators\Validator;

class OptionValidator extends Validator
{
	protected $rules = [
		'value' => 'required',
		'product_attribute_id' => 'required|exists:product_attributes,id'
	];
}