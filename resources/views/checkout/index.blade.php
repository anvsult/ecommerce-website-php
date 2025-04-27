<x-app-layout> {{-- Start wrapping with the layout component --}}

    {{-- Optional: Define the header slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>
    <div class="container py-5">
        <h2 class="mb-4">Checkout</h2>

        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Summary</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($cart as $id => $details)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $cartItemsDetails[$id]->name }}</strong>
                                <p class="mb-0">Quantity: {{ $details['quantity'] }}</p>
                            </div>
                            <span>${{ number_format($cartItemsDetails[$id]->price * $details['quantity'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-3 text-end">
                    <h5>Total: ${{ number_format($total, 2) }}</h5>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <form action="{{ route('checkout.placeOrder') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5>Billing Details</h5>
                </div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="form-outline mb-4">
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                        <label class="form-label" for="name">Name</label>
                    </div>

                    <!-- Email -->
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        <label class="form-label" for="email">Email</label>
                    </div>

                    <!-- Address -->
                    <div class="form-outline mb-4">
                        <textarea id="address" name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        <label class="form-label" for="address">Address</label>
                    </div>

                    <!-- Payment Type -->
                    <div class="mb-4">
                        <label class="form-label">Payment Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_type" id="cash_on_delivery" value="cash_on_delivery" {{ old('payment_type') == 'cash_on_delivery' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="cash_on_delivery">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_type" id="card" value="card" {{ old('payment_type') == 'card' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="card">Card</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
