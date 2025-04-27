<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page displaying products
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Product search (for AJAX and standard search)
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// View a single product
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Management (excluding public index/show)
    Route::resource('products', ProductController::class)->except(['index', 'show']);

    // Cart Management
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout Process
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Dashboard Route (Optional Landing Page for Auth Users)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes
require __DIR__.'/auth.php';
