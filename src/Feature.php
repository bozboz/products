<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Admin\Base\Model;

class Feature extends Model
{
	protected $fillable = array('name', 'slug');

	public function products()
	{
		return $this->belongsToMany('Bozboz\Ecommerce\Products\Product', 'featured_products');
	}

	public function getValidator()
	{
		return new FeatureValidator;
	}
}
