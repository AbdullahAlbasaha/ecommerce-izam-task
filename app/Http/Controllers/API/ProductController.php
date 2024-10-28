<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Contracts\ProductRepositoryInterface as ProdInterface;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:sanctum','abilities:admin'])->only(['store','destroy','update']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProdInterface $prodInterface)
    {
        try {
            return $prodInterface->productsCollection($request)->additional(['message' => 'products are retrieved successfully']);
        } catch (\Throwable $th) {
            $this->response_has_errors($th->getMessage(),'field to retrieve products !',code:500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request,ProdInterface $prodInterface)
    {
        try {
            return $prodInterface->create_product($request)->additional(['message' => 'succeed to create new product'])->response()->setStatusCode(201);
        } catch (\Throwable $th) {
            $this->response_has_errors($th->getMessage(),'field to create product !',code:500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product,ProdInterface $prodInterface)
    {
        try {
            return $prodInterface->update_product($request,$product)->additional(['message' => 'succeed to update  product'])->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            $this->response_has_errors($th->getMessage(),'field to update product !',code:500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product,ProdInterface $prodInterface)
    {
        try {
            return $prodInterface->delete_product($product);
        } catch (\Throwable $th) {
            $this->response_has_errors($th->getMessage(),'field to delete product !',code:500);
        }
    }
}
