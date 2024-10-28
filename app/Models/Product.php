<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    public function scopeFilter($query,Request $request)
    {
      return $query->when($request->name,function($query)use($request){
        $query->where('name','LIKE','%'.$request->name.'%');
      })->when($request->price_from && $request->price_to,function($query)use($request){
        $query->whereBetween('price',[$request->price_from , $request->price_to]);
      });
    }
}
