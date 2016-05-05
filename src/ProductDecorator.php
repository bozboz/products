<?php

namespace Bozboz\Ecommerce\Products;

use Bozboz\Admin\Base\ModelAdminDecorator;
use Bozboz\Admin\Fields\BelongsToField;
use Bozboz\Admin\Fields\BelongsToManyField;
use Bozboz\Admin\Fields\CheckboxField;
use Bozboz\Admin\Fields\HTMLEditorField;
use Bozboz\Admin\Fields\MediaBrowser;
use Bozboz\Admin\Fields\SelectField;
use Bozboz\Admin\Fields\TextField;
use Bozboz\Admin\Fields\URLField;
use Bozboz\Admin\Reports\Filters\ArrayListingFilter;
use Bozboz\Admin\Reports\Filters\SearchListingFilter;
use Bozboz\Ecommerce\Products\Brands\BrandDecorator;
use Bozboz\Ecommerce\Products\Categories\CategoryDecorator;
use Bozboz\Ecommerce\Products\Pricing\PriceField;
use Bozboz\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Html;

class ProductDecorator extends ModelAdminDecorator
{
	protected $categoryDecorator;
	protected $attributeDecorator;
	// protected $shippingDecorator;

	public function __construct(
		Product $model,
		CategoryDecorator $categoryDecorator,
		BrandDecorator $brandDecorator,
		AttributeOptionDecorator $attributeDecorator//,
		// ShippingBandDecorator $shippingDecorator
	)
	{
		$this->categoryDecorator = $categoryDecorator;
		$this->brandDecorator = $brandDecorator;
		$this->attributeDecorator = $attributeDecorator;
		// $this->shippingDecorator = $shippingDecorator;

		parent::__construct($model);
	}

	public function getColumns($product)
	{
		return array(
			'ID' => sprintf('<span class="id">#%s</span>', str_pad($product->id, 3, '0', STR_PAD_LEFT)),
			'Name' => $product->name,
			'Variants' => $product->exists ? $this->linkToVariants($product->variants) : null,
			'Category' => $product->exists ? $this->linkToCategory($product->categories) : null,
			// 'Price' => format_money($product->price_pence),
			'Stock Level' => $product->exists ? (count($product->variants) ? '-' : $product->stock_level) : null,
			'Added' => $product->created_at ? sprintf('<abbr title="%s">%s</a>',
				$product->created_at->format('jS F Y'),
				$product->created_at->diffForHumans()
			) : null
		);
	}

	protected function linkToVariants($variants)
	{
		$links = [];

		foreach($variants as $variant) {
			$links[] = '- ' . Html::linkAction(
				'\Bozboz\Ecommerce\Products\Http\Controllers\Admin\ProductController@edit',
				implode(' ', $variant->attributeOptions->pluck('value')->all()) . ' (' . $variant->stock_level . ')',
				[ $variant->id ]
			);
		}

		return implode('<br>', $links);
	}

	protected function linkToCategory($categories)
	{
		$links = [];

		foreach($categories as $category) {
			$links[] = '- ' . Html::linkAction(
				'\Bozboz\Ecommerce\Products\Http\Controllers\Admin\CategoryController@edit',
				$category->name,
				[ $category->id ]
			);
		}

		return implode('<br>', $links);
	}

	protected function modifyListingQuery(Builder $query)
	{
		$query->visible();

		parent::modifyListingQuery($query);
	}

	public function getListingFilters()
	{
		return [
			new ArrayListingFilter('category', $this->getCategoryList(), function($builder, $value) {
				if ($value) {
					$builder->whereHas('categories', function($q) use ($value) {
						$q->where('categories.id', $value);
					});
				}
			}),
			new ArrayListingFilter('stock_level', $this->getStockLevelList(), function($builder, $value){
				switch ($value) {
					case 'in_stock':
						$builder->where('stock_level', '>', 0);
					break;

					case 'out_of_stock':
						$builder->where(function($q){
							$q->whereNull('stock_level')
							  ->orWhere('stock_level', '=', 0);
						});
					break;
				}
			}),
			new SearchListingFilter('search', ['sku', 'name'])
		];
	}

	private function getCategoryList()
	{
		return [ null => 'All' ] + $this->model->category()->getRelated()->orderBy('parent_id')->orderBy('name')->pluck('name', 'id')->all();
	}

	private function getStockLevelList()
	{
		return [
			null => 'All',
			'out_of_stock' => 'Out of stock only',
			'in_stock' => 'In stock only',
		];
	}

	public function getLabel($product)
	{
		$variantLabel = $product->variation_of_id ? ' (' . implode(', ', $product->attributeOptions->pluck('value')->all()) . ')' : '';
		return $product->name . $variantLabel;
	}

	public function getFields($instance)
	{
		$variationsOf = $this->model->whereNull('variation_of_id')->orderBy('name')->pluck('name', 'id')->all();

		$commonFields = [
			new TextField('name'),
			new CheckboxField('status'),
			new HTMLEditorField('description'),
			new PriceField('price', ['label' => 'Base Price']),
			new TextField('stock_level'),
			// new BelongsToField($this->shippingDecorator, $instance->shippingBand()),
			new TextField('weight'),
			new TextField(['name' => 'sku', 'label' => 'SKU']),
			new MediaBrowser($instance->media()),
		];

		return array_merge($commonFields, $this->getAdditionalFields($instance));
	}

	protected function getAdditionalFields($instance)
	{
		if ($instance->variation_of_id) {
			$fields = [
				new BelongsToManyField(
					$this->attributeDecorator, $instance->attributeOptions(), [ 'label' => 'Attributes' ], function($query) {
						$query->with('attribute')->orderBy('product_attribute_id')->orderBy('value');
					}
				)
			];
		} else {
			$fields = [
				// new URLField('slug', ['route' => Config::get('ecommerce::urls.products')]),
				new BelongsToField($this->brandDecorator, $instance->brand()),
				new BelongsToManyField(
					$this->categoryDecorator, $instance->categories(), ['label' => 'Categories']
				),
				new BelongsToManyField(
					$this, $instance->relatedProducts(), ['label' => 'Related Products'], function($query) {
						$query->visible();
					}
				)
			];
		}

		return $fields;
	}

	public function getSyncRelations()
	{
		return ['categories', 'relatedProducts', 'attributeOptions', 'media'];
	}

	/**
	 * Return a new instance of Product or ProductVariant, dependent on given
	 * $attributes array.
	 *
	 * @param  array  $attributes
	 * @return Bozboz\Ecommerce\Products\Product
	 */
	public function newModelInstance($attributes = array())
	{
		if ( ! empty($attributes['variation_of_id'])) {
			return (new ProductVariant)->newInstance($attributes);
		}

		return parent::newModelInstance($attributes);
	}

	/**
	 * Lookup instance by ID and return as Product or ProductVariant, dependent
	 * on given $attributes array.
	 *
	 * @param  int  $id
	 * @return Bozboz\Ecommerce\Products\Product
	 */
	public function findInstance($id)
	{
		$instance = parent::findInstance($id);

		if ( ! $instance->variation_of_id) return $instance;

		$variant = new ProductVariant;
		$variant->setRawAttributes($instance->getAttributes());
		$variant->exists = true;

		return $variant;
	}
}
