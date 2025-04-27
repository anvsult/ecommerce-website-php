<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    // Add middleware constructor if implementing role checks here
    // public function __construct() {
    //     $this->middleware('is_admin'); // Assuming you create an 'is_admin' middleware
    // }

    public function listOrders()
    {
        // Fetch orders, maybe newest first, with user and items preloaded
        $orders = Order::with('user', 'items') // Eager load relationships
        ->latest()
            ->paginate(15); // Paginate results

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        // Load relationships if not already loaded or if needed again
        $order->load('user', 'items.product'); // Load product details for items

        return view('admin.orders.show', compact('order'));
    }

    // Add methods for updateStatus, etc.
}
