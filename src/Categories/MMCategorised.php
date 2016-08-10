<?php

namespace Bozboz\Ecommerce\Products\Categories;

trait MMCategorised
{
    public function categories()
    {
        return $this->belongsToMany($this->getCategoryClass())->withTimestamps();
    }

    public function scopeForCategory($query, $categoryId)
    {
        $query->whereHas('categories', function($query) use ($categoryId) {
            $query->whereId($categoryId);
        });
    }

    abstract protected function getCategoryClass();
}