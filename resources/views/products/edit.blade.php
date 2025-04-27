<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Display Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="PUT" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="form-outline mb-4">
                        <input type="text" id="name" name="name" class="form-control" value="{{ $product->name }}" required />
                        <label class="form-label" for="name">Product Name</label>
                    </div>

                    <!-- Category -->
                    <div class="form-outline mb-4">
                        <input type="text" id="category" name="category" class="form-control" value="{{ $product->category }}" />
                        <label class="form-label" for="category">Category</label>
                    </div>

                    <!-- Description -->
                    <div class="form-outline mb-4">
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                        <label class="form-label" for="description">Description</label>
                    </div>

                    <!-- Price -->
                    <div class="form-outline mb-4">
                        <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ $product->price }}" required />
                        <label class="form-label" for="price">Price</label>
                    </div>

                    <!-- Stock Quantity -->
                    <div class="form-outline mb-4">
                        <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" min="0" value="{{ $product->stock_quantity, 0 }}" required/>
                        <label class="form-label" for="stock_quantity">Stock Quantity</label>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="form-label" for="image">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>


                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Create Product</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Script for MDB Input Initialization (usually at end of body or in app.js) --}}
    <script>
        // Initialize MDB input fields after page load if not using automatic initialization
        document.querySelectorAll('.form-outline').forEach((formOutline) => {
            new mdb.Input(formOutline).init();
        });
    </script>
</x-app-layout>
