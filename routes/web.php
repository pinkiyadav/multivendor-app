<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Models\Product;

Route::get('/', function() {
    $products = Product::with('vendor')->get();
    return view('products', compact('products'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/products', function() {
    $products = Product::with('vendor')->get();
    return view('products', compact('products'));
})->name('products');

Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');
});