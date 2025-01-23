<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Management Routes
    Route::prefix('management')->name('management.')->group(function () {
        Route::get('/', [ManagementController::class, 'index'])->name('index');
        Route::post('/', [ManagementController::class, 'store'])->name('store');
        Route::get('{type}/{id}/edit', [ManagementController::class, 'edit'])->name('edit');
        Route::put('{type}/{id}', [ManagementController::class, 'update'])->name('update');
        Route::delete('{type}/{id}', [ManagementController::class, 'destroy'])->name('destroy');
    });
});

// Public Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shopping-profile', [ProfileController::class, 'showShoppingProfile'])->name('shopping-profile');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'viewCart'])->name('view');
    Route::post('add/{id}', [CartController::class, 'add'])->name('add');
    Route::post('update/{id}', [CartController::class, 'updateQuantity'])->name('updateQuantity');
    Route::get('remove/{id}', [CartController::class, 'removeItem'])->name('remove');
    Route::post('clear', [CartController::class, 'clearCart'])->name('clear');
});


// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});
// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// API Routes
// Route::prefix('api')->group(function () {
//     // Mpesa Payment Routes
//     Route::prefix('c2b')->group(function () {
//         Route::post('/validation', [MpesaController::class, 'validateTransaction']);
//         Route::post('/confirmation', [MpesaController::class, 'confirmTransaction']);
//         Route::post('/simulate-payment', [MpesaController::class, 'simulatePayment'])->name('api.simulatePayment');
//     });
//     Route::get('/csrf-token', function () {
//         return response()->json(['csrf_token' => csrf_token()]);
//     });
// });


// Route to display the access token form
Route::get('/mpesa/access-token', [MpesaController::class, 'showAccessTokenForm'])->name('mpesa.token.form');

// Route to handle the access token generation
Route::post('/mpesa/access-token', [MpesaController::class, 'generateAccessToken'])->name('mpesa.token.generate');


Route::get('/mpesa/register-url', [MpesaController::class, 'registerUrlForm'])->name('mpesa.register-url');

// Handle the form submission to register URL
Route::post('/mpesa/register-url', [MpesaController::class, 'registerUrl'])->name('mpesa.register-url.submit');
// Include Auth Routes
require __DIR__ . '/auth.php';
