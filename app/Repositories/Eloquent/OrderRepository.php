<?php
namespace App\Repositories\Eloquent;


use App\Models\Admin;

use App\Models\Order;

use App\Traits\HelperTrait;
use App\Repositories\Contracts\OrderRepositoryInterface;


class OrderRepository implements OrderRepositoryInterface {
    use HelperTrait;

     /**
     * create order
     *
    * @param Request $request
     * @return \App\Models\Order
     * @throws \Exception
     **/
    public function create(array $fields){
        try {
            return Order::create($fields);
        } catch (\Throwable $th) {
            $this->error_log('create order error',$th);
            throw $th;
        }
    }
   /**
     * add order items
     *
   * @param Order $order
    * @param array $items
     * @throws \Exception
     **/
    public function add_order_items(Order $order,array $items){
        foreach ($items as $item) {
            $order->items()->attach($item['product_id'],[
                'sku' => $item['sku'],
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ]);
        }
    }


}
