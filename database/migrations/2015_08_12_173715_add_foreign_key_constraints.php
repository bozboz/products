<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::transaction(function($connection)
		{

			/**
			 * Deleting a category containing a product is restricted
			 * Deleting a parent product deletes the variations
			 * Deleting a shipping band containing a product nullifies the shipping_band_id
			 */
			Schema::table('products', function(Blueprint $table)
			{
				$table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
				$table->foreign('variation_of_id')->references('id')->on('products')->onDelete('cascade');
				// $table->foreign('shipping_band_id')->references('id')->on('shipping_bands')->onDelete('set null');
			});

			/**
			 * Deleting a product attribute deletes the associated options
			 */
			Schema::table('product_attribute_options', function(Blueprint $table)
			{
				$table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
			});

			/**
			 * Deleting a product attribute option deletes the link to product
			 */
			Schema::table('product_product_attribute_option', function(Blueprint $table)
			{
				$table->foreign('product_attribute_option_id', 'product_attribute_option_id_foreign')->references('id')->on('product_attribute_options')->onDelete('cascade');
			});

			/**
			 * Deleting a parent category deletes the children
			 */
			Schema::table('categories', function(Blueprint $table)
			{
				$table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
			});

			/**
			 * Deleting a category or product removes the link
			 */
			Schema::table('category_product', function(Blueprint $table)
			{
				$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
				$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			});

			/**
			 * Deleting a product removes the link to a related product
			 */
			Schema::table('related_products', function(Blueprint $table)
			{
				$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
				$table->foreign('related_product_id')->references('id')->on('products')->onDelete('cascade');
			});

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('products', function(Blueprint $table)
		{
			$table->dropForeign('products_category_id_foreign');
			$table->dropForeign('products_variation_of_id_foreign');
			// $table->dropForeign('products_shipping_band_id_foreign');
		});

		Schema::table('product_attribute_options', function(Blueprint $table)
		{
			$table->dropForeign('product_attributes_options_product_attribute_id_foreign');
		});

		Schema::table('product_product_attribute_option', function(Blueprint $table)
		{
			$table->dropForeign('product_attribute_option_id_foreign');
		});

		Schema::table('categories', function(Blueprint $table)
		{
			$table->dropForeign('categories_parent_id_foreign');
		});

		Schema::table('category_product', function(Blueprint $table)
		{
			$table->dropForeign('category_product_category_id_foreign');
			$table->dropForeign('category_product_product_id_foreign');
		});

		Schema::table('related_products', function(Blueprint $table)
		{
			$table->dropForeign('related_products_product_id_foreign');
			$table->dropForeign('related_products_related_product_id_foreign');
		});

	}

}
