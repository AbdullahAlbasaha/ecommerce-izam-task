<?php
namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Http\Request;

interface OrderRepositoryInterface   {
  /**
     * create order
     *
    * @param array $fields
     * @return \App\Models\Order
     * @throws \Exception
     **/
    public function create(array $fields);
     /**
     * add order items
     *
    * @param Order $order
    * @param array $items
     * @throws \Exception
     **/
    public function add_order_items(Order $order,array $items);
}
