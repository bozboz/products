<?php

namespace Bozboz\Ecommerce\Products\Brands;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Admin\Fields\MediaBrowser;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Fields\URLField;
use Illuminate\Support\Facades\Config;

class BrandDecorator extends ModelAdminDecorator
{
	public function __construct(Brand $brand)
	{
		parent::__construct($brand);
	}

	public function getColumns($brand)
	{
		return [
			'Name' => $this->getLabel($brand),
		];
	}

	public function getLabel($brand)
	{
		return $brand->name;
	}

	public function getFields($brand)
	{
		if (Config::get('ecommerce::urls.brands')) {
			$urlField = new URLField('slug', ['route' => Config::get('ecommerce::urls.brands')]);
		} else {
			$urlField = null;
		}

		return [
			new TextField('name'),
			$urlField,
			new MediaBrowser($brand->logo())
		];
	}
}
