<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Need Product model

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []); // Get cart from session or empty array
        $total = 0;

        // Get product details and calculate total
        $cartItems = [];
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            } else {
                // Product not found, remove from cart (optional safety)
                $request->session()->forget("cart.$id");
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        // Check stock (optional but recommended)
        if ($product->stock_quantity < 1) {
            return redirect()->back()->with('error', 'Product is out of stock!');
        }

        if(isset($cart[$product->id])) {
            // Increment quantity if product already exists in cart
            // Check stock availability before incrementing
            if ($product->stock_quantity < ($cart[$product->id]['quantity'] + 1)) {
                return redirect()->back()->with('error', 'Not enough stock available!');
            }
            $cart[$product->id]['quantity']++;
        } else {
            // Add new product to cart
            if ($product->stock_quantity < 1) { // Re-check just in case
                return redirect()->back()->with('error', 'Product is out of stock!');
            }
            $cart[$product->id] = [
                "name" => $product->name, // Store name for easier display maybe
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image // Store image path
            ];
        }

        $request->session()->put('cart', $cart); // Save cart back to session

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
        // Or return redirect()->back()->with('success', 'Product added!');
    }

    public function update(Request $request, $productId) // Use $productId from route
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = $request->session()->get('cart');

        if(isset($cart[$productId])) {
            // Optional: Check stock before updating
            $product = Product::find($productId);
            if ($product && $product->stock_quantity < $request->quantity) {
                return redirect()->route('cart.index')->with('error', 'Not enough stock for the requested quantity!');
            }

            $cart[$productId]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
    }

    public function remove(Request $request, $productId)
    {
        $cart = $request->session()->get('cart');

        if(isset($cart[$productId])) {
            unset($cart[$productId]); // Remove item from array
            $request->session()->put('cart', $cart); // Save updated cart
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart'); // Remove cart from session completely
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}
