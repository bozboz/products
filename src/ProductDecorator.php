<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Ecommerce\Products\ProductInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class ProductDecorator extends ModelAdminDecorator
{
	private $presenter;

	public function __construct(ProductInterface $model)
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

	public function getLabel($product)
	{
		return $this->presenter->getLabel($product);
	}

	public function getFields($instance)
	{
		return $this->presenter->getFields($instance);
	}

	public function getSyncRelations()
	{
		return $this->presenter->getSyncRelations();
	}

	protected function modifyListingQuery(Builder $query)
	{
		$query->visible();

		parent::modifyListingQuery($query);
	}
}
