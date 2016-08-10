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
	private $presenter;

	public function __construct(CategoryInterface $model)
	{
		parent::__construct($model);

		$this->presenter = $this->getPresenter();
	}

	abstract protected function getPresenter();

	public function getColumns($product)
	{
		return $this->presenter->getColumns($product);
	}

	public function getListingFilters()
	{
		return $this->presenter->getListingFilters($this->model);
	}

	public function getFields($instance)
	{
		return $this->presenter->getFields($instance);
	}

	public function modifyListingQuery(Builder $query)
	{
		$query->with('products');
	}

	public function getLabel($model)
	{
		return str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $model->depth) . $model->name;
	}

	// public function getFields($instance)
	// {
	// 	return array_merge([
	// 		new TextField('name'),
	// 		new TreeSelectField(
	// 			$this->model->all(),
	// 			['name' => 'parent_id', 'label' => 'Parent Category']
	// 		),
	// 	], $this->getAdditionalFields($instance));
	// }

	// abstract public function getAdditionalFields($instance);
}
