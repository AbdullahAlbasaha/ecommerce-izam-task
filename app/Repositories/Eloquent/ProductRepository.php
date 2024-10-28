<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface {
    use HelperTrait;
    private $cache_key;
    private $perPage;
    /**
     * display products by pagination
     *
     * can filter products by name and price range
     *
     * @param Request $request
     * @return ProductCollection
     * @throws \Exception
     **/
    public function productsCollection(Request $request){
        try {
            $this->prepare_cache_key($request);

              if (!$products = $this->get_cache()) {
                $products =  Product::select(['id','name','price','sku','stock'])->filter($request)->paginate($this->perPage);
                $this->set_cache($products);
             }
        return  new ProductCollection($products);
        } catch (\Throwable $th) {
            $this->error_log('get products collection error',$th);
            throw $th;
        }

    }
    private function get_cache()
    {
          if (Cache::has($this->cache_key)) {
          return Cache::get($this->cache_key);
        }
    }
    private function set_cache($products)
    {
        Cache::remember($this->cache_key, ttl: now()->addMinutes(5), callback: function () use ($products) {
            return $products;
        });
    }
     private function prepare_cache_key($request)
    {
        $this->perPage = $request->query('per_page',50);
        $page = $request->query('page',1);
        $name = $request->query('name','name');
        $price_from = $request->query('price_from','price_from');
        $price_to = $request->query('price_to','price_to');
        $this->cache_key =  "products_{$this->perPage}_{$page}_{$name}_{$price_from}_{$price_to}";
    }
       /**
     * create new product
     *
     * store new product into db and return it as response
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     * @throws \Exception
     **/
    public function create_product(StoreProductRequest $request){
        try {
            $product =  Product::create($request->all());
            return new ProductResource($product);
        } catch (\Throwable $th) {
                  $this->error_log('crate product error',$th);
                  throw $th;
              }
    }
        /**
     * update existed product
     *
     * update one product by its id
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return ProductResource
     * @throws \Exception
     **/
    public function update_product(UpdateProductRequest $request,Product $product){
        try {
            $product->update($request->all());
            return new ProductResource($product);
        } catch (\Throwable $th) {
            $this->error_log('update product error',$th);
            throw $th;
        }
    }
    /**
     * delete existed product
     *
     * delete one product by its id
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     **/
    public function delete_product(Product $product){
        try {
            $product->delete();
            return response()->noContent();
        } catch (\Throwable $th) {
            $this->error_log('delete product error',$th);
            throw $th;
        }
    }
}
