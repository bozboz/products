<?php

namespace Bozboz\Ecommerce\Products\Http\Controllers\Admin;

use Bozboz\Admin\Http\Controllers\ModelAdminController;
use Bozboz\Admin\Reports\NestedReport;
use Bozboz\Admin\Reports\Report;
use Bozboz\Ecommerce\Products\Categories\CategoryDecorator;
use Bozboz\Ecommerce\Products\Product;
use Bozboz\Ecommerce\Products\ProductDecorator;
use Illuminate\Support\Facades\View;

class CategoryController extends ModelAdminController
{
    protected $useActions = true;

    public function __construct(CategoryDecorator $decorator)
    {
        parent::__construct($decorator);
    }

    protected function getListingReport()
    {
        return new NestedReport($this->decorator);
    }

    protected function getProductsReport($parentCategory = null)
    {
        $decorator = new ProductDecorator(new Product);

        if (!is_null($parentCategory)) {
            $decorator->setCategory($parentCategory);
        }

        return new Report($decorator, new ProductController($decorator));
    }
}
