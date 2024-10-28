<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function items()
    {
        if (request()->routeIs('placeOrder')) {
            return $this->belongsToMany(Product::class,'orders_items')->withPivot(['qty','price','name','sku']);
        }
        //to  retrieve all items in case of any product_id is null
        return $this->hasMany(OrdersItem::class);
    }

}
