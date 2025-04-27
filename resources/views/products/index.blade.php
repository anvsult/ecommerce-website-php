<x-app-layout> {{-- Assuming you use Breeze's layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif

                {{-- Link to create product for logged-in users --}}
                @auth
                    <div class="mb-4">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                    </div>
                @endauth

                <div class="mb-4">
                    <input type="text" id="product-search-input" class="form-control" placeholder="Search products by name or category...">
                </div>
                {{-- Include the product list partial --}}
                <div id="product-list-container">
                    @include('products.partials.list', ['products' => $products])
                </div>

                {{-- Pagination Links --}}
                <div id="pagination-container" class="mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> {{-- Or import if using vite --}}
<script>
    const searchInput = document.getElementById('product-search-input');
    const productListContainer = document.getElementById('product-list-container');
    const paginationContainer = document.getElementById('pagination-container');
    let searchTimeout; // To debounce requests

    searchInput.addEventListener('keyup', function() {
        clearTimeout(searchTimeout); // Clear previous timeout
        const query = this.value;

        // Debounce: Wait 500ms after user stops typing
        searchTimeout = setTimeout(() => {
            fetchProducts(query);
        }, 500);
    });

    function fetchProducts(query = '', page = 1) {
        const searchUrl = '{{ route("products.search") }}'; // Use Laravel named route

        // Add page parameter for pagination clicks
        axios.get(searchUrl, {
            params: {
                query: query,
                page: page // Send current page number
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Important for request->ajax() check in Laravel
            }
        })
            .then(response => {
                // Update product list and pagination links with the HTML returned from server
                if(response.data.html) {
                    productListContainer.innerHTML = response.data.html;
                }
                if(response.data.pagination) {
                    paginationContainer.innerHTML = response.data.pagination;
                } else {
                    paginationContainer.innerHTML = ''; // Clear pagination if none returned
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                // Optionally display an error message to the user
                productListContainer.innerHTML = '<p class="text-danger">Error loading products.</p>';
                paginationContainer.innerHTML = '';
            });
    }

    // **Handle Pagination Clicks via AJAX**
    // Need to attach event listener dynamically as pagination links are replaced
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a pagination link within the container
        if (event.target.matches('#pagination-container .pagination a')) {
            event.preventDefault(); // Prevent default link navigation

            const url = new URL(event.target.href);
            const page = url.searchParams.get('page'); // Get page number from link href
            const currentQuery = searchInput.value; // Get current search query

            fetchProducts(currentQuery, page); // Fetch results for the new page
        }
    });

</script>
