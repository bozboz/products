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
    }

    public function boot()
    {
        $packageRoot = __DIR__ . '/../..';

        $this->publishes([
            "{$packageRoot}/database/migrations/" => database_path('migrations')
        ], 'migrations');
    }
}
