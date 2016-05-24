<?php

namespace Bozboz\Ecommerce\Products;

interface ProductInterface
{
    public function relatedProducts();

    public function scopeActive($query);

    public function scopeVisible($query);

    public function scopeSearch($query, $searchTerm);

    public function isAvailable();
}