<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $q = $request->input('query', '');
        $products = Product::when($q, fn($qbr) =>
        $qbr->where('name','like', "%{$q}%")
            ->orWhere('category','like', "%{$q}%")
        )
            ->paginate(12)
            ->appends(['query' => $q]);

        return view('products.index', compact('products'));
    }
//    public function index()
//    {
//        $query = Product::query();
//
//        if (request()->has('search') && request('search') !== '') {
//            $search = request('search');
//
//            $query->where(function ($q) use ($search) {
//                $q->where('name', 'like', '%{search}%')
//                    ->orWhere('category', 'like', '%{search}%')
//                    ->orWhere('description', 'like', '%{search}%');
//            });
//        }
//        $products = $query->orderBy('created_at', 'desc')->paginate(9);
//        return view('products.index', compact('products'));
////        $products = Product::paginate(9);
////        return view('products.index', compact('products'));
//    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if new file is uploaded
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Delete image file if it exists
        if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Search products (optional feature).
     */
//    public function search(Request $request)
//    {
//        $query = $request->input('query');
//        $products = Product::where('name', 'like', "%{$query}%")->get();
//
//        return view('products.index', compact('products'));
//    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // If it's an AJAX request, return the partial list only
        if ($request->ajax()) {
            return view('products.partials.list', compact('products'))->render();
        }

        // Otherwise, fallback (optional)
        return view('products.index', compact('products'));
    }
}
