<?php

namespace Bozboz\Ecommerce\Products\Presenters;

interface Presentable
{
    public function getLabel($instance);

    public function getColumns($instance);

    public function getFields($instance);

    public function getListingFilters($model);

    public function getSyncRelations();
}
