<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Admin\Base\DynamicSlugTrait;
use Bozboz\Admin\Base\Model;

abstract class Product extends Model implements ProductInterface
{
	protected $table = 'products';

	use DynamicSlugTrait;

	public function getSlugSourceField()
	{
		return 'name';
	}

	public function relatedProducts()
	{
		return $this->belongsToMany(static::class, 'related_products', 'product_id', 'related_product_id')->withTimestamps();
	}

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}

	public function scopeSearch($query, $searchTerm)
	{
		$query->where('name', 'LIKE', '%' . $searchTerm . '%');
	}

	public function label()
	{
		if ($parent = $this->variationOf) {
			return sprintf('<strong>%s</strong> %s (%s)', $this->reference, $parent->name, $this->name);
		} else {
			return $this->name;
		}
	}
}
