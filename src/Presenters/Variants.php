<?php

namespace Bozboz\Ecommerce\Products\Presenters;

use HTML;

class Variants extends Presenter
{
    private $editAction;

    public function __construct($editAction, Presentable $presenter)
    {
        $this->editAction = $editAction;
        parent::__construct($presenter);
    }

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

    private function linkToVariants($variants)
    {
        return $variants->map(function($variant) {
            return '- ' . Html::linkAction(
                $this->editAction,
                $variant->name . ' (' . $variant->stock_level . ')',
                [ $variant->id ]
            );
        })->implode('<br>');
    }
}