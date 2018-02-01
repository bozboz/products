# Products package

## Installation

See http://gitlab.lab/laravel-packages/ecommerce

## Usage

There's an awful lot of stuff in here that's never been used and you can and probably should just ignore it. Unless what you need is the exact setup contained within this package (it's very unlikely that it is) you're much better off setting up your products manually. Provided they implement the `Orderable` interface in the orders package it should all work fine.

There are some useful bits in the package, though. These are:

- `Bozboz\Ecommerce\Products\Pricing\PriceTrait`
- `Bozboz\Ecommerce\Products\Pricing\PriceField` __\#TODO:__ Move this to admin.
- `Bozboz\Ecommerce\Products\OrderableProduct`

### OrderableProduct

While you're probably better off not actually using this class it's a good example of implementing an orderable/shippable model.

### Price

Prices should be stored as pence. Ideally in a field called `price_pence`. In order to calculate the tax the priced model should have a field called `tax_rate`. The PriceTrait will handle the conversion from pence to pounds for you and calculate the tax rate. 
