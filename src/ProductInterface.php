<?php

namespace Bozboz\Ecommerce\Products;

interface ProductInterface
{
    public function getRawPriceField();

    public function attributeOptions();

    public function relatedProducts();

    public function scopeActive($query);

    public function scopeVisible($query);

    public function scopeByPrice($query, $price);

    public function scopeSearch($query, $searchTerm);

    public function brand();

    public function category();

    public function categories();

    public function variants();

    public function variationOf();

    public function getVariantsList();

    // public function isAvailable(User $user = null);

}