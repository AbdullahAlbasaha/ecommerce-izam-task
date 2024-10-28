<?php
namespace App\Services\PlaceOrder;

use Illuminate\Http\Request;

interface PlaceOrderServiceInterface   {

  /**
     * Place Order
     *
     * this method is responsible for handling place order process
     *
     * @param Request $request
     * @throws \Exception
     **/
    public function placeOrder(Request $request);
}
