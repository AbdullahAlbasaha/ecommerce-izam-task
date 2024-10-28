<?php
namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


interface ProductRepositoryInterface  {
    /**
     * create new product
     *
     * store new product into db and return it as response
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     * @throws \Exception
     **/
    public function create_product(StoreProductRequest $request);
     /**
     * display products by pagination
     *
     * can filter products by name and price range
     *
     * @param Request $request
     * @return ProductCollection
     * @throws \Exception
     **/
    public function productsCollection(Request $request);
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
    public function update_product(UpdateProductRequest $request,Product $product);
        /**
     * delete existed product
     *
     * delete one product by its id
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     **/
    public function delete_product(Product $product);
}
