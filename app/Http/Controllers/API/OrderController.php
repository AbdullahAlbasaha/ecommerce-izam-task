<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
use App\Services\PlaceOrder\PlaceOrderServiceFacade;

class OrderController extends Controller
{

    public function __construct(){
        $this->middleware(['auth:sanctum','abilities:user'])->only(['index','place_order','show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderCollection::collection(auth()->user()->orders)->additional(['message '=>'orders retrieved successfully'])->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function place_order(Request $request)
    {
        try {
            $order =  PlaceOrderServiceFacade::placeOrder($request);
        } catch (\Throwable $th) {
            if($th instanceof \Illuminate\Http\Exceptions\HttpResponseException){
                throw $th;
            }else{

                $this->response_has_errors($th->getMessage(),'failed to place order');
            }

        }
        return response()->json(['data' => ['order_id' => $order->id],'message' => "succeed to place order number $order->id"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return (new OrderResource($order))->additional(['message' => 'success process']);
    }


    // private function prepare_items_data(Request $request)
    // {
    //    $items = $request->items;
    //    $data = [];
    //    foreach ($items as $item) {
    //     $product = Product::find($item['product_id']);
    //     $price = $product->price;
    //     $data []= ['name' => $product->name,'sku' => $product->sku,'price' => $price,'qty' => $item['qty'],'stock' => $product->stock,'product_id' => $product->id];
    //    }
    //    $this->items =  $data;
    // }
    // private function calculate_order_total(){

    //     $this->total = array_sum(\Arr::pluck($this->items, 'price'));
    // }
    // private function link_order_items()
    // {
    //     foreach ($this->items as $item) {
    //         $this->order->items()->attach($item['product_id'],[
    //             'sku' => $item['sku'],
    //             'name' => $item['name'],
    //             'price' => $item['price'],
    //             'qty' => $item['qty'],
    //         ]);
    //     }
    // }
    // private function check_OOS()
    // {
    //    $this->OOS_items = array_filter($this->items,function($item){
    //     return $item['qty'] > $item['stock'];
    //    });
    // }
    // private function update_products_stocks()
    // {
    //     foreach ($this->items as $item) {
    //         $updated_stock = $item['stock'] - $item['qty'];
    //         Product::whereId($item['product_id'])->update(['stock' => $updated_stock]);
    //     }
    // }
}
