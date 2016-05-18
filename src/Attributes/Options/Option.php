<?php

namespace Bozboz\Ecommerce\Products\Attributes\Options;

use Bozboz\Admin\Base\Model;
use Bozboz\Ecommerce\Products\Attributes\Attribute;

class Option extends Model
{
	protected $table = 'product_attribute_options';
	protected $fillable = ['value', 'product_attribute_id'];

	public function attribute()
	{
		return $this->belongsTo(Attribute::class, 'product_attribute_id');
	}

	public function products()
	{
		return $this->belongsToMany(
			'Bozboz\Ecommerce\Products\Product',
			'product_product_attribute_option',
			'product_id',
			'product_attribute_option_id'
		)->withTimestamps();
	}

	public function getValidator()
	{
		return new OptionValidator;
	}
}
