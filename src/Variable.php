<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Ecommerce\Products\Attributes\Options\Option;

/**
 * summary
 */
trait Variable
{
    public function attributeOptions()
    {
        return $this->belongsToMany(
            Option::class,
            'product_product_attribute_option',
            'product_id',
            'product_attribute_option_id'
        )->withTimestamps();
    }

    public function variantLabel()
    {
        $attributeOptions = $this->attributeOptions()->lists('value');
        $stockAvailability = '';

        if (!$this->isAvailable()) {
            $stockAvailability = '&nbsp;&nbsp;(OUT OF STOCK)';
        } elseif ($this->stock_level < 10) {
            $stockAvailability = '&nbsp;&nbsp;(Less than 10 in stock)';
        }

        return implode(' ', $attributeOptions) . ' - ' . $this->price . $stockAvailability;
    }

    public function scopeVisible($query)
    {
        return $query->whereNull('variation_of')->with('variants');
    }

    public function variants()
    {
        return $this->hasMany(static::class, 'variation_of');
    }

    public function variationOf()
    {
        return $this->belongsTo(static::class, 'variation_of');
    }

    public function getVariantsList()
    {
        $list = [];
        $variants = $this->variants()->with('attributeOptions')->get();

        foreach($variants as $variant) {
            $list[$variant->id] = [
                'label' => $variant->variantLabel(),
                'is_available' => $variant->isAvailableWithVariants(),
            ];
        }

        return $list;
    }

    /**
     * @return boolean
     */
    public function isAvailableWithVariants()
    {
        $stockLevel = 0;

        if ($this->variants->count()) {
            foreach($this->variants as $variant) {
                $stockLevel += $variant->stock_level;
            }
        } else {
            $stockLevel = $this->stock_level;
        }

        return $stockLevel > 0;
    }
}