<?php

namespace Bozboz\Ecommerce\Products\Categories;

use Bozboz\Admin\Base\Model;
use Bozboz\Admin\Base\SanitisesInputTrait;
use Bozboz\Admin\Base\Sorting\NestedSortableTrait;
use Bozboz\Admin\Base\Sorting\Sortable;
use Bozboz\Admin\Base\DynamicSlugTrait;
use Bozboz\Admin\Media\MediableTrait;
use Kalnoy\Nestedset\NodeTrait;

abstract class Category extends Model implements Sortable, CategoryInterface
{
	use MediableTrait, SanitisesInputTrait, NodeTrait, NestedSortableTrait, DynamicSlugTrait;

	abstract protected function getProductClass();

	public function sortBy()
	{
		return '_lft';
	}

	public function getSlugSourceField()
	{
		return 'slug';
	}

	public function products()
	{
		return $this->belongsToMany($this->getProductClass());
	}
}
