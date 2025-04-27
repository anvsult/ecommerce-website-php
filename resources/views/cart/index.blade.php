<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                @endif

                @if (count($cartItems) > 0)
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item['product']->image ?? 'https://via.placeholder.com/50' }}" alt="" style="width: 45px; height: 45px" class="rounded-circle"/>
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1">{{ $item['product']->name }}</p>
                                            <p class="text-muted mb-0">{{ Str::limit($item['product']->description, 30) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($item['product']->price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 60px;" onchange="this.form.submit()">
                                        {{-- Optional: Add update button instead of onchange --}}
                                        {{-- <button type="submit" class="btn btn-link btn-sm p-0 ms-2">Update</button> --}}
                                    </form>
                                </td>
                                <td>${{ number_format($item['subtotal'], 2) }}</td>
                                <td>
                                    {{-- Remove Button --}}
                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-floating">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to clear the cart?');">Clear Cart</button>
                            </form>
                        </div>
                        <div class="text-end">
                            <h4>Total: ${{ number_format($total, 2) }}</h4>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>

                @else
                    <p>Your cart is empty.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
