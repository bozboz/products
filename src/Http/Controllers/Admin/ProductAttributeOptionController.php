<?php

namespace Bozboz\Ecommerce\Products\Http\Controllers\Admin;

use Bozboz\Admin\Http\Controllers\ModelAdminController;
use Bozboz\Admin\Reports\Actions\CreateAction;
use Bozboz\Admin\Reports\Report;
use Bozboz\Ecommerce\Products\Attributes\Attribute;
use Bozboz\Ecommerce\Products\Attributes\Options\OptionDecorator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProductAttributeOptionController extends ModelAdminController
{
    protected $useActions = true;

    public function __construct(OptionDecorator $decorator)
    {
        parent::__construct($decorator);
    }

    // public function index()
    // {
    //     $report = new Report($this->decorator);
    //     $report->overrideView('products.admin.attribute-options-overview');
    //     return $report->render(array('controller' => get_class($this)));
    // }

    /**
     * Return an array of actions the report can perform
     *
     * @return array
     */
    protected function getReportActions()
    {
        return [
            new CreateAction(
                [$this->getActionName('createForAttribute'), Input::get('attribute')],
                [$this, 'canCreate'],
                ['label' => 'New ' . $this->decorator->getHeading()]
            )
        ];
    }

    public function createForAttribute($attribute_id)
    {
        $instance = $this->decorator->newModelInstance();

        $attribute = Attribute::find($attribute_id);
        $instance->attribute()->associate($attribute);

        return $this->renderFormFor($instance, $this->createView, 'POST', 'store');
    }

    protected function getSuccessResponse($instance)
    {
        return Redirect::action('\\' . get_class($this) . '@index', ['attribute' => $instance->product_attribute_id]);
    }

    protected function getListingUrl($instance)
    {
        return action('\\' . get_class($this) . '@index', ['attribute' => $instance->product_attribute_id]);
    }
}
