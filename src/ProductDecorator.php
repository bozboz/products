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
		return ['categories', 'relatedProducts', 'attributeOptions', 'media'];
	}

	protected function modifyListingQuery(Builder $query)
	{
		$query->visible();

		parent::modifyListingQuery($query);
	}

	/**
	 * Return a new instance of Product or ProductVariant, dependent on given
	 * $attributes array.
	 *
	 * @param  array  $attributes
	 * @return Bozboz\Ecommerce\Products\Product
	 */
	public function newModelInstance($attributes = array())
	{
		if ( ! empty($attributes['variation_of_id'])) {
			return (new ProductVariant)->newInstance($attributes);
		}

		return parent::newModelInstance($attributes);
	}

	/**
	 * Lookup instance by ID and return as Product or ProductVariant, dependent
	 * on given $attributes array.
	 *
	 * @param  int  $id
	 * @return Bozboz\Ecommerce\Products\Product
	 */
	public function findInstance($id)
	{
		$instance = parent::findInstance($id);

		if ( ! $instance->variation_of_id) return $instance;

		$variant = new ProductVariant;
		$variant->setRawAttributes($instance->getAttributes());
		$variant->exists = true;

		return $variant;
	}
}
