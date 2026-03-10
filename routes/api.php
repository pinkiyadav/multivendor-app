<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
//Route::middleware('auth:sanctum')->post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/admin/orders', [OrderController::class, 'orders']);
//Route::get('/admin/orders', [AdminController::class, 'orders']);