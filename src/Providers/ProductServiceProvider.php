<?php

namespace Bozboz\Ecommerce\Products\Providers;

use Bozboz\Ecommerce\Cart\Cart;
use Bozboz\Ecommerce\Cart\CartObserver;
use Bozboz\Ecommerce\Checkout\Checkout;
use Bozboz\Ecommerce\Payment\IFrameSagePayGateway;
use Bozboz\Ecommerce\Payment\PayPalGateway;
use Bozboz\Ecommerce\Payment\SagePayGateway;
use Illuminate\Support\ServiceProvider;
use Omnipay\Omnipay;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Bozboz\Ecommerce\Products\Contracts\Product::class,
            \Bozboz\Ecommerce\Products\Product::class
        );
    }

    public function boot()
    {
        $packageRoot = __DIR__ . '/../..';

        if (! $this->app->routesAreCached()) {
            require "{$packageRoot}/src/Http/routes.php";
        }

        $this->publishes([
            "{$packageRoot}/database/migrations/" => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            $packageRoot . '/config/products.php' => config_path('products.php')
        ], 'config');

        // $this->loadTranslationsFrom("{$packageRoot}", 'products');

        $this->buildAdminMenu();
    }

    private function buildAdminMenu()
    {
        $event = $this->app['events'];

        $event->listen('admin.renderMenu', function($menu)
        {
            $lang = $this->app['translator'];

            $menu->appendToItem($lang->get(config('products.menu_name')), [
                'Products' => 'admin.products.index',
                'Categories' => 'admin.categories.index',
                'Brands' => 'admin.brands.index',
            ]);
        });
    }
}
