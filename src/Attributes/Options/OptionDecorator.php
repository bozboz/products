<?php

namespace Bozboz\Ecommerce\Products\Attributes\Options;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Admin\Fields\HiddenField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Reports\Filters\RelationFilter;
use Bozboz\Ecommerce\Products\Attributes\AttributeDecorator;
use Illuminate\Database\Eloquent\Builder;

class OptionDecorator extends ModelAdminDecorator
{
	private $attributes;

	public function __construct(Option $model, AttributeDecorator $attributes)
	{
		parent::__construct($model);
		$this->attributes = $attributes;
	}

	public function getLabel($instance)
	{
		return $instance->attribute->name . ' - ' . $instance->value;
	}

	public function getFields($instance)
	{
		return [
			new TextField('value'),
			new HiddenField('product_attribute_id'),
		];
	}

	public function getColumns($instance)
	{
		return [
			'Value' => $instance->value,
			'Attribute' => $instance->attribute->name
		];
	}

	public function getListingFilters()
	{
		return [
			new RelationFilter($this->model->attribute(), $this->attributes),
		];
	}

	public function modifyListingQuery(Builder $query)
	{
		$query->orderBy('value');
	}
}
