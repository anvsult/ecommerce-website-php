<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10); // Get latest products with pagination
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $data = $request->except('image'); // Get all data except image first

        if ($request->hasFile('image')) {
            // Store the image in storage/app/public/products
            // Make sure to run `php artisan storage:link`
            $path = $request->file('image')->store('public/products');
            // Store the path relative to the 'public' disk's root
            $data['image'] = Storage::url($path); // Get the web-accessible URL
            // Alternative: Store just the path $path and prepend Storage::url() in the view
            // $data['image'] = $path; // Store relative path from storage/app
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $data = $request->except('image'); // Get all data except image first

        if ($request->hasFile('image')) {
            // Optional: Delete old image if it exists
            if ($product->image) {
                // Assuming $product->image stores path like 'public/products/xyz.jpg'
                $oldPath = str_replace('/storage', 'public', $product->image); // Adjust if you store path differently
                Storage::delete($oldPath);
            }
            $path = $request->file('image')->store('public/products');
            $data['image'] = Storage::url($path);
            // $data['image'] = $path; // Alternative path storage
        }

        $product->update($data);

        return redirect()->route('products.index') // Or redirect to admin list
        ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            $oldPath = str_replace('/storage', 'public', $product->image);
            Storage::delete($oldPath);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            // Return all products or an empty set if query is empty
            $products = Product::latest()->paginate(10); // Or Product::query()->limit(0)->get();
        } else {
            $products = Product::where('name', 'LIKE', "%{$query}%")
                ->orWhere('category', 'LIKE', "%{$query}%")
                // ->orWhere('description', 'LIKE', "%{$query}%") // Optional: search description too
                ->latest()
                ->paginate(10); // Paginate search results too
        }


        // Option 1: Return rendered HTML partial
        if ($request->ajax()) { // Check if it's an AJAX request
            // Render a partial view containing just the product list part
            $html = view('products.partials.list', compact('products'))->render();
            // Also render pagination links if needed
            $pagination = $products->links('pagination::bootstrap-5')->render();

            // Include pagination HTML in the response
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

        // Option 2: Return JSON (Frontend JS handles rendering)
        // if ($request->ajax()) {
        //     return response()->json($products); // Returns paginated data structure
        // }


        // For non-AJAX requests (e.g., if JS fails), return the full view
        return view('products.index', compact('products'));
    }
}
