<?php
namespace App\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public route to view all products
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Public route to view a single product
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/create', [ProductController::class, 'show'])->name('products.create');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Management Routes (only accessible to logged-in users)
    // Exclude public index/show if you want separate admin listing
    // Route::resource('admin/products', ProductController::class)->except(['index', 'show']);

    // OR, if any authenticated user can manage products as per requirement:
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    // We keep index/show public above, so exclude them from the authenticated group
    // If you need a separate admin listing page, create a new route/method.


    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update'); // Using productId to avoid confusion with product ID
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success'); // Optional success page

});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Example: Route for listing orders in admin area
    Route::get('/orders', [AdminController::class, 'listOrders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    // Add routes for updating order status etc. if needed
});

require __DIR__.'/auth.php';
