<?php

namespace Bozboz\Ecommerce\Products\Categories;

trait Categorised
{
    public function category()
    {
        return $this->belongsTo($this->getCategoryClass());
    }

    public function scopeForCategory($query, $categoryId)
    {
        $query->with('categories')->whereHas('category', function($query) use ($categoryId) {
            $query->find($categoryId);
        });
    }

    abstract protected function getCategoryClass();
}