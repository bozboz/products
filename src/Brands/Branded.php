<?php

namespace Bozboz\Ecommerce\Products\Brands;

trait Branded
{
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeByBrand($query, $brandId)
    {
        $query->with('brand')->whereHas('brand', function($query) use ($brandId) {
            $query->find($brandId);
        });
    }
}