<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Login\UserController;
use App\Http\Controllers\API\Login\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('products',ProductController::class);
Route::post('place-order',[OrderController::class,'place_order'])->name('placeOrder');
Route::get('orders',[OrderController::class,'index']);
Route::get('order-details/{order}',[OrderController::class,'show'])->name('orderDetails');
//auth
Route::post('user-login',[UserController::class,'login']);
Route::post('admin-login',[AdminController::class,'login']);
Route::post('register',[RegisterController::class,'register']);
