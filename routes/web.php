<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/shopping-profile', [ProfileController::class, 'showShoppingProfile'])->name('shopping-profile');

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');

Route::get('/product-detail', [App\Http\Controllers\ProductDetailController::class, 'index'])->name('product');  // RESTFUL API Convension for detail view

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');

require __DIR__ . '/auth.php';
