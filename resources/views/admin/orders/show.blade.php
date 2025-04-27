@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Order Details</h2>

        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($order->status) }}
                </span>
                </p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Payment Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Payment Type:</strong> {{ ucfirst($order->payment_type) }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <!-- Items Purchased -->
        <div class="card">
            <div class="card-header">
                <h5>Items Purchased</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-end">
                    <h5>Total: ${{ number_format($order->total, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
