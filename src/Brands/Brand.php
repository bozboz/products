<?php

namespace Bozboz\Ecommerce\Products\Brands;

use Bozboz\Admin\Base\DynamicSlugTrait;
use Bozboz\Admin\Base\Model;
use Bozboz\Admin\Media\Media;
use Bozboz\Ecommerce\Products\Brands\BrandValidator;
use Bozboz\Ecommerce\Products\Product;

class Brand extends Model
{
	use DynamicSlugTrait;

	protected $table = 'brands';

	protected $fillable = ['name', 'logo_id'];

	public function getSlugSourceField()
	{
		return 'name';
	}

	public function getValidator()
	{
		return new BrandValidator;
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function logo()
	{
		return Media::forModel($this, 'logo_id');
	}
}
