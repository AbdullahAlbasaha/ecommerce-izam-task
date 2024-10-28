<?php
namespace App\Services\PlaceOrder;
use Illuminate\Support\Facades\Facade;

class PlaceOrderServiceFacade extends Facade {
    protected static function getFacadeAccessor() { return "PlaceOrderService"; }
}
