<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('description');
			$table->unsignedInteger('category_id')->nullable();
			$table->integer('price_pence')->nullable();
			$table->decimal('tax_rate', 4, 2)->nullable();
			$table->unsignedInteger('variation_of_id')->nullable();
			$table->unsignedInteger('brand_id')->nullable();
			$table->unsignedInteger('stock_level')->nullable();
			$table->unsignedInteger('weight')->nullable();
			$table->string('sku', 50)->nullable();
			$table->boolean('status');
			// $table->integer('shipping_band_id')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
