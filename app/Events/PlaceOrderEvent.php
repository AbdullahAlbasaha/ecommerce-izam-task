<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;

class PlaceOrderEvent
{
    use  SerializesModels;

    public function __construct(
        public Order $order,
    ) {}


}
