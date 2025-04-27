<?php
namespace App\Http\Controllers;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
