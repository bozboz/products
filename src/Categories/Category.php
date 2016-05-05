<?php

namespace Bozboz\Ecommerce\Products\Categories;

use Bozboz\Admin\Base\Model;
use Bozboz\Admin\Base\SanitisesInputTrait;
use Bozboz\Admin\Base\Sorting\NestedSortableTrait;
use Bozboz\Admin\Base\Sorting\Sortable;
use Bozboz\Admin\Media\MediableTrait;
use Bozboz\Ecommerce\Products\Product;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model implements Sortable
{
	use MediableTrait, SanitisesInputTrait, NodeTrait, NestedSortableTrait;

	protected $nullable = ['parent_id'];

	protected $table = 'categories';

	protected $fillable = [
		'name',
		'slug',
		'description',
		'parent_id'
	];

	public function sortBy()
	{
		return '_lft';
	}

	public function products()
	{
		return $this->belongsToMany(Product::class);
	}

	public function getValidator()
	{
		return new CategoryValidator;
	}
}
