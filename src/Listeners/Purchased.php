<?php

namespace Bozboz\Ecommerce\Products\Listeners;

class Purchased
{
    public function handle($event)
    {
        $event->item->orderable->purchased($event->item->quantity);
    }
}