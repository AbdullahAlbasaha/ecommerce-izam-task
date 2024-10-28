<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Contracts\AdminRepositoryInterface;


class AdminRepository implements AdminRepositoryInterface {
    use HelperTrait;
   /**
     * retrieve admin
     *
     * retrieve admin by specific fields and where clause
     *
     * @param array $fields
     * @return Admin
     * @throws \Exception
     **/
    public function retrieve_admin(array $fields = []){
        try {
            
            return Admin::where($fields)->first();
        } catch (\Throwable $th) {
            $this->error_log('retrieve admin',$th);
            throw $th;
        }
    }
}
