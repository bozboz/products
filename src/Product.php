<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Admin\Base\DynamicSlugTrait;
use Bozboz\Admin\Base\Model;
use Bozboz\Admin\Media\MediableTrait;
use Bozboz\Ecommerce\Products\AttributeOption;
use Bozboz\Ecommerce\Products\Brands\Brand;
use Bozboz\Ecommerce\Products\Categories\Category;
use Bozboz\Ecommerce\Products\Contracts\Product as Contract;
use Bozboz\Ecommerce\Products\Pricing\PriceRangeParser;
use Bozboz\Ecommerce\Products\Pricing\PriceTrait;
use Bozboz\Users\Membership\MemberPricesTrait;
use Bozboz\Users\User;
use Illuminate\Support\Facades\Validator as ValidationFactory;
use Illuminate\Validation\Validator;

class Product extends Model implements Contract
{
	protected $table = 'products';

	use MediableTrait, DynamicSlugTrait, PriceTrait;

	protected $fillable = [
		'name',
		'slug',
		'description',
		'category_id',
		'brand_id',
		'variation_of_id',
		'stock_level',
		'weight',
		'sku',
		'nominal_code',
		'status',
		'tax_exempt',
		'shipping_band_id',

		'price',
		'price_includes_tax',
		'prices_data',
		'new_prices_data',
	];

	protected $nullable = [
		'category_id',
		'brand_id',
		'variation_of_id',
		'shipping_band_id',
	];

	public function getValidator()
	{
		return new ProductValidator;
	}

	public function getRawPriceField()
	{
		return 'price_pence';
	}

	public function getSlugSourceField()
	{
		return 'name';
	}

	public function attributeOptions()
	{
		return $this->belongsToMany(
			AttributeOption::class,
			'product_product_attribute_option',
			'product_id',
			'product_attribute_option_id'
		)->withTimestamps();
	}

	public function relatedProducts()
	{
		return $this->belongsToMany(get_class($this), 'related_products', 'product_id', 'related_product_id')->withTimestamps();
	}

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}

	public function scopeVisible($query)
	{
		return $query->whereNull('variation_of_id')->with('variants');
	}

	public function scopeByPrice($query, $price)
	{
		$priceRange = new PriceRangeParser($price);
		return $priceRange->filter($query);
	}

	public function scopeSearch($query, $searchTerm)
	{
		$query->where('name', 'LIKE', '%' . $searchTerm . '%');
	}

	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
	}

	public function variants()
	{
		return $this->hasMany(ProductVariant::class, 'variation_of_id');
	}

	public function variationOf()
	{
		return $this->belongsTo(get_class($this), 'variation_of_id');
	}

	// public function shippingBand()
	// {
	// 	return $this->belongsTo('Bozboz\Ecommerce\Shipping\ShippingBand');
	// }

	public function getVariantsList()
	{
		$list = [];
		$variants = $this->variants()->with('attributeOptions')->get();

		foreach($variants as $variant) {
			$list[$variant->id] = [
				'label' => $variant->variantLabel(),
				'is_available' => $variant->isAvailable(),
			];
		}

		return $list;
	}

	/*
	 * @param  Bozboz\Users\User|null  $user
	 * @return boolean
	 */
	public function isAvailable(User $user = null)
	{
		$stockLevel = 0;

		if ($this->variants->count()) {
			foreach($this->variants as $variant) {
				$stockLevel += $variant->stock_level;
			}
		} else {
			$stockLevel = $this->stock_level;
		}

		return $stockLevel > 0;
	}
}
