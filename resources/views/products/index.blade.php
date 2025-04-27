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
                <form id="search-form" action="{{ route('products.search') }}" method="GET" class="flex items-center space-x-2 mb-4">
                    <input type="text" name="search" id="search-input" placeholder="Search products..."
                           class="form-input w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-white"
                           value="{{ request('search') }}">

                    <button type="submit"
                            class="px-4 mx-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            style="background-color: #2563eb;"
                    >
                        Search
                    </button>
                </form>


                {{-- Include the product list partial --}}
                <div id="product-list-items">
                    @include('products.partials.list', ['products' => $products])
                </div>

                {{-- Pagination Links --}}
                <div id="pagination-container" class="mt-4">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> {{-- Or import if using vite --}}
<script>
    const searchInput          = document.getElementById('product-search-input');
    const productListContainer = document.getElementById('product-list-container');
    const paginationContainer  = document.getElementById('pagination-container');
    let searchTimeout;

    searchInput.addEventListener('keyup', () => {
        clearTimeout(searchTimeout);
        const q = searchInput.value;

        searchTimeout = setTimeout(() => {
            fetchProducts(q);
        }, 500);
    });

    function fetchProducts(query = '', page = 1) {
        axios.get('{{ route("products.search") }}', {
            params: { query, page },
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(({ data }) => {
                productListContainer.innerHTML = data.html;
                paginationContainer.innerHTML  = data.pagination;
            })
            .catch(err => console.error(err));
    }

    // Handle clicks on pagination links:
    document.addEventListener('click', e => {
        if (e.target.matches('#pagination-container .pagination a')) {
            e.preventDefault();
            const url  = new URL(e.target.href);
            const page = url.searchParams.get('page');
            fetchProducts(searchInput.value, page);
        }
    });

</script>
