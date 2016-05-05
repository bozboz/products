<?php

namespace Bozboz\Ecommerce\Products\Brands;

use Bozboz\Admin\Services\Validators\Validator;

class BrandValidator extends Validator
{
	protected $rules = [
		'name' => 'required',
		// 'logo_id' => 'required'
	];

	protected $editRules = [
		'slug' => 'required|unique:brands'
	];
}
