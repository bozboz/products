<?php

/**
 * Admin routes
 */
Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Bozboz\Ecommerce\Products\Http\Controllers\Admin'], function()
{
    /* Products */
    Route::resource('products', 'ProductController', ['except' => 'show']);

    /* Categories */
    Route::resource('categories', 'CategoryController', ['except' => 'show']);

    /* Brands */
    Route::resource('brands', 'BrandController', ['except' => 'show']);

});
