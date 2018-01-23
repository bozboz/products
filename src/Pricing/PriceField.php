<?php

namespace Bozboz\Ecommerce\Products\Pricing;

use Bozboz\Admin\Fields\TextField;
use Form;

class PriceField extends TextField
{
	public function getInput()
	{
		$input = parent::getInput();
		if ($this->show_tax_toggle !== false) {
			$tax = Form::hidden('price_includes_tax', 0) . Form::label('price_includes_tax', 'Includes tax', [
				'style' => 'display: inline-block; padding-right: 8px'
			])
			 . Form::checkbox('price_includes_tax');
		} else {
			$tax = null;
		}

		return <<<HTML
			<div class="input-group">
				<span class="input-group-addon">&pound;</span>
				{$input}
				<span class="input-group-addon">
					{$tax}
				</span>
			</div>
HTML;
	}
}
