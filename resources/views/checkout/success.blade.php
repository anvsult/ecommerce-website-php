<x-app-layout> {{-- Start wrapping with the layout component --}}

    {{-- Optional: Define the header slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>
    <div class="container py-5">
        <div class="text-center">
            <h1 class="mb-4">Thank You for Your Order!</h1>
            <p class="lead">Your order has been successfully placed.</p>
            <p class="mb-4">Order Number: <strong>#{{ $order->id }}</strong></p>
        </div>

        <!-- Order Summary -->
        <div class="card">
            <div class="card-header">
                <h5>Order Summary</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item->product_name }}</strong>
                                <p class="mb-0">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-3 text-end">
                    <h5>Total: ${{ number_format($order->total, 2) }}</h5>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</x-app-layout>
