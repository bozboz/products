<?php

namespace Bozboz\Ecommerce\Products\Categories;

use Bozboz\Admin\Services\Validators\Validator;

class CategoryValidator extends Validator
{
	protected $rules = array(
		'name' => 'required',
	);

	protected $editRules = [
		'slug' => 'required'
	];
}
