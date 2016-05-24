<?php

namespace Bozboz\Ecommerce\Products\Presenters;

class Variants extends Presenter
{
    public function getLabel($instance)
    {
        $variantLabel = $instance->variation_of_id ? ' (' . implode(', ', $instance->attributeOptions->pluck('value')->all()) . ')' : '';
        return $this->presenter->getLabel($instance) . $variantLabel;
    }

    public function getColumns($instance)
    {
        return array_merge($this->presenter->getColumns($instance), [
            'Variants' => $instance->exists ? $this->linkToVariants($instance->variants) : null,
        ]);
    }

    public function getFields($instance)
    {
        return array_merge($this->presenter->getFields($instance), [

        ]);
    }

    private function linkToVariants($variants)
    {
        $links = [];

        foreach($variants as $variant) {
            // $links[] = '- ' . Html::linkAction(
            //     '\Bozboz\Ecommerce\Products\Http\Controllers\Admin\ProductController@edit',
            //     implode(' ', $variant->attributeOptions->pluck('value')->all()) . ' (' . $variant->stock_level . ')',
            //     [ $variant->id ]
            // );
        }

        return implode('<br>', $links);
    }
}