<?php

namespace Bozboz\Ecommerce\Products\Events;

use Bozboz\Ecommerce\Products\Product;

class StockLevelDepleted
{
	public $product;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}
}
