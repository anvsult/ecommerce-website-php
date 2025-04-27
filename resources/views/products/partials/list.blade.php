{{-- resources/views/products/partials/list.blade.php --}}
<div class="row" id="product-list-items"> {{-- Give the container an ID --}}
    @forelse ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                {{-- Card content as in products/index.blade.php --}}
                @if($product->image)
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    {{-- ... other card details ... --}}
                    <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    {{-- ... buttons ... --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline"> @csrf <button type="submit" class="btn btn-success btn-sm">Add to Cart</button> </form>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                    @auth
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        {{-- Delete form --}}
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p>No products found matching your search.</p>
        </div>
    @endforelse
</div>
