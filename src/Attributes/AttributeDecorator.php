<?php

namespace Bozboz\Ecommerce\Products\Attributes;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Admin\Fields\TextField;

class AttributeDecorator extends ModelAdminDecorator
{
	public function __construct(Attribute $model)
	{
		parent::__construct($model);
	}

	public function getColumns($instance)
	{
		return array(
			'Name' => $instance->name,
			'Options' => $instance->options()->pluck('value')->implode(', '),
			'' => link_to_route(
				'admin.products.attributes.options.index',
				'Edit Options',
				['attribute' => $instance->id],
				['class' => 'btn btn-sm btn-default']
			)
		);
	}

	public function getLabel($instance)
	{
		return $instance->name;
	}

	public function getFields($instance)
	{
		return [
			new TextField('name'),
		];
	}
}
