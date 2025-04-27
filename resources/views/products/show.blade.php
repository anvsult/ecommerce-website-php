<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="col-md-6">
                        <h3>{{ $product->name }}</h3>
                        <p><strong>Category:</strong> {{ $product->category }}</p>
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>

                        <!-- Back Button -->
                        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
