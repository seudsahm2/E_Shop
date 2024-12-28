<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\Admin\ProductController;
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


Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/shopping-profile', [ProfileController::class, 'showShoppingProfile'])->name('shopping-profile');

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');

// Route::get('/product-detail', [App\Http\Controllers\ProductDetailController::class, 'index'])->name('product');  // RESTFUL API Convension for detail view

Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::get('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');

require __DIR__ . '/auth.php';
