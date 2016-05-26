<?php

namespace Bozboz\Ecommerce\Products\Presenters;

class Presenter implements Presentable
{
    protected $presenter;

    public function __construct(Presentable $presenter)
    {
        $this->presenter = $presenter;
    }

    public function getLabel($instance)
    {
        return $this->presenter->getLabel($instance);
    }

    public function getColumns($instance)
    {
        return $this->presenter->getColumns($instance);
    }

    public function getFields($instance)
    {
        return $this->presenter->getFields($instance);
    }

    public function getListingFilters($model)
    {
        return $this->presenter->getListingFilters($model);
    }

    public function getSyncRelations()
    {
        return $this->presenter->getSyncRelations();
    }
}
