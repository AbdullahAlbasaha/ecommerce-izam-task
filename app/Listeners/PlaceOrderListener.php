<?php

namespace App\Listeners;

use App\Events\PlaceOrderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlaceOrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PlaceOrderEvent $event): void
    {
        //send notification after order is placed
        \Log::info('order placed',[$event->order]);
    }
}
