<?php

namespace Bozboz\Ecommerce\Products\Attributes;

use Bozboz\Admin\Base\Model;
use Bozboz\Ecommerce\Products\Attributes\Options\Option;

class Attribute extends Model
{
	protected $table = 'product_attributes';
	protected $fillable = ['name'];

	public function options()
	{
		return $this->hasMany(Option::class, 'product_attribute_id');
	}

    public function getValidator()
    {
        return new AttributeValidator;
    }
}
