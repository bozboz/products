<?php

namespace Bozboz\Ecommerce\Products\Categories;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Admin\Fields\MediaBrowser;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Fields\TextareaField;
use Bozboz\Admin\Fields\TreeSelectField;
use Bozboz\Admin\Fields\URLField;
use Bozboz\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Config, Html;

abstract class CategoryDecorator extends ModelAdminDecorator
{
	public function __construct(Category $model)
	{
		parent::__construct($model);
	}

	public function modifyListingQuery(Builder $query)
	{
		$query->with('products');
	}

	public function getColumns($category)
	{
		return array(
			'Name' => $this->getLabel($category),
			// 'Page' => Html::linkRoute(Config::get('ecommerce::urls.products'), null, $category->slug),
			'Products' => $category->products()->count()
		);
	}

	public function getLabel($model)
	{
		return $model->name;
	}

	public function getFields($instance)
	{
		return array_merge([
			new TextField('name'),
			new TreeSelectField(
				$this->model->all(),
				['name' => 'parent_id', 'label' => 'Parent Category']
			),
		], $this->getAdditionalFields($instance));
	}

	abstract public function getAdditionalFields($instance);
}
