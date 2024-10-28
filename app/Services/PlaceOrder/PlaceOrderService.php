<?php

namespace App\Services\PlaceOrder;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Events\PlaceOrderEvent;
use App\Services\PlaceOrder\PlaceOrderServiceInterface;
use App\Repositories\Contracts\OrderRepositoryInterface as OrderInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;

class PlaceOrderService implements PlaceOrderServiceInterface
{
    use HelperTrait;
    private const RULES = [
        'items' => ['required','array'],
        'items.*.product_id' => ['required','integer','exists:products,id'],
        'items.*.qty' => ['required','integer','gt:0'],
    ];
    private const MESSAGES = ['exists' => 'product is not existed'];
    private const NICE_NAMES = ['items.*.product_id' => 'product','items.*.qty' => 'quantity'];
    private int $total;
    private array $items;
    private array $OOS_items;
    private Order $order;
  /**
     * Place Order
     *
     * this method is responsible for handling place order process
     *
     * @param Request $request
     * @throws \Exception
     **/
    private OrderInterface $orderInterface;
    private ProductRepositoryInterface $productRepository;
      function __construct(OrderInterface $orderInterface,ProductRepositoryInterface $productRepositoryInterface){
        $this->orderInterface = $orderInterface;
        $this->productRepository = $productRepositoryInterface;
      }
    public function placeOrder(Request $request){

        //validation
       $this->validation($request,self::RULES,self::MESSAGES,self::NICE_NAMES);

        $this->prepare_items_data($request);

        $this->check_OOS(); //check out of stock products

        $this->calculate_order_total();
            try {
                \DB::beginTransaction();
                //use transactions here + try catch
                $this->order = $this->orderInterface->create([
                    'user_id' => auth()->user()->id,
                    'total' => $this->total,
                ]);
                $this->orderInterface->add_order_items($this->order,$this->items);
                $this->update_products_stocks();
                \DB::commit();
               event(new PlaceOrderEvent($this->order));
               return $this->order;
            } catch (\Throwable $th) {
               \DB::rollBack();
               $this->error_log('place order error',$th);
               throw $th;
            }

    }

    private function prepare_items_data(Request $request)
    {
       $items = $request->items;
       $data = [];
       foreach ($items as $item) {
        $product = Product::find($item['product_id']);
        $price = $product->price;
        $data []= ['name' => $product->name,'sku' => $product->sku,'price' => $price,'qty' => $item['qty'],'stock' => $product->stock,'product_id' => $product->id];
       }
       $this->items =  $data;
    }
    private function calculate_order_total(){

        $this->total = array_sum(\Arr::pluck($this->items, 'price'));
    }
    private function link_order_items()
    {
        foreach ($this->items as $item) {
            $this->order->items()->attach($item['product_id'],[
                'sku' => $item['sku'],
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ]);
        }
    }
    private function check_OOS()
    {
        foreach ($this->items as $item) {
            if ($item['qty'] > $item['stock']) {
               $this->response_has_errors(message:"item that has name {$item['name']} and sku {$item['sku']}  is out of stock",code:422);
           }
         }
    }
    private function update_products_stocks()
    {
        $updateProductRequest = new UpdateProductRequest ;
        foreach ($this->order->items as $product) {
            $updated_stock = $product->stock - $product->pivot->qty;
            $this->productRepository->update_product($updateProductRequest->merge(['stock' => $updated_stock]),$product);

            // $product->update(['stock' => $updated_stock]);
            // $updated_stock = $item['stock'] - $item['qty'];
            // Product::whereId($item['product_id'])->update(['stock' => $updated_stock]);
        }
    }

}
