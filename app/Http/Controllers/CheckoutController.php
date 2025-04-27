<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Needed for stock check/update
use Illuminate\Support\Facades\DB; // For database transactions

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $cartItemsDetails = []; // To pass product details to the view if needed
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if($product){
                $total += $product->price * $details['quantity'];
                $cartItemsDetails[$id] = $product; // Store product model for display
            } else {
                // Handle case where product might have been deleted since adding to cart
                unset($cart[$id]);
                $request->session()->put('cart', $cart); // Update session cart
                return redirect()->route('cart.index')->with('error', 'Some items in your cart are no longer available.');
            }
        }

        // Pass cart details and total to the checkout view
        return view('checkout.index', compact('cart', 'cartItemsDetails', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_type' => 'required|string|in:cash_on_delivery,card', // Example payment types
        ]);

        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $orderItemsData = [];

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // 1. Recalculate total and prepare order items data on the server-side
            foreach ($cart as $id => $details) {
                $product = Product::find($id); // Use find to get the latest data

                if (!$product) {
                    throw new \Exception("Product with ID {$id} not found."); // Rollback if product missing
                }

                $currentQuantity = $details['quantity'];

                // **Bonus: Stock Check**
                if ($product->stock_quantity < $currentQuantity) {
                    throw new \Exception("Not enough stock for product: {$product->name}. Available: {$product->stock_quantity}");
                }

                $itemTotal = $product->price * $currentQuantity;
                $total += $itemTotal;

                $orderItemsData[] = [
                    // 'order_id' will be set after order creation
                    'product_id' => $product->id,
                    'product_name' => $product->name, // Capture name at time of order
                    'quantity' => $currentQuantity,
                    'price' => $product->price, // Capture price at time of order
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // **Bonus: Reduce Stock**
                // $product->decrement('stock_quantity', $currentQuantity);
                // OR using lockForUpdate for better concurrency handling:
                $product = Product::where('id', $id)->lockForUpdate()->first();
                if ($product->stock_quantity < $currentQuantity) {
                    throw new \Exception("Stock level changed for {$product->name}. Please try again.");
                }
                $product->stock_quantity -= $currentQuantity;
                $product->save();

            }

            // 2. Create the Order
            $order = Order::create([
                'user_id' => Auth::id(), // Get logged-in user's ID
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'shipping_address' => $request->address,
                'payment_type' => $request->payment_type,
                'total_amount' => $total,
                'status' => 'pending', // Initial status
            ]);

            // 3. Create Order Items and associate with the Order
            // Add 'order_id' to each item data
            foreach ($orderItemsData as &$itemData) { // Use reference '&'
                $itemData['order_id'] = $order->id;
            }
            OrderItem::insert($orderItemsData); // Bulk insert for efficiency

            // 4. Clear the cart from session
            $request->session()->forget('cart');

            // 5. Commit the transaction
            DB::commit();

            // 6. Redirect to a success page (pass order ID or number)
            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            // 7. Rollback transaction on error
            DB::rollBack();

            // Log the error (optional)
            // Log::error('Order placement failed: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->route('checkout.index')->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    // Optional: Success page
    public function success(Order $order) // Use route model binding
    {
        // Make sure the logged-in user owns this order (security check)
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        return view('checkout.success', compact('order'));
    }
}
