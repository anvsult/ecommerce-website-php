<nav x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    {{-- Add other links like Products, Cart here using x-nav-link --}}
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        {{ __('Cart') }}
                    </x-nav-link>
                    {{-- Conditionally show Admin link --}}
                    @can('viewAdmin', App\Models\User::class) {{-- Example Gate Check --}}
                    <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                        {{ __('Admin Orders') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            {{-- Removed text/bg/hover color classes: text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 --}}
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                                {{-- Text color will now inherit or use browser/MDB default --}}
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    {{-- Removed fill-current from SVG, let button color control it --}}
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor"> {{-- Added fill="currentColor" --}}
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Requires changes inside x-dropdown-link component itself --}}
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Removed specific text/hover color classes. Added 'nav-link' potentially for MDB styling. --}}
                    <a href="{{ route('login') }}"
                       class="nav-link font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"> {{-- Added nav-link, removed color classes --}}
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="nav-link ms-4 font-semibold focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"> {{-- Added nav-link, removed color classes --}}
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                {{-- Removed text/hover/focus color/bg classes --}}
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md hover:bg-opacity-75 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    {{-- Apply changes inside x-responsive-nav-link component --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden"> {{-- Corrected AlpineJS class binding --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- Add other responsive links --}}
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Cart') }}
            </x-responsive-nav-link>
            @can('viewAdmin', App\Models\User::class)
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                    {{ __('Admin Orders') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600"> {{-- Kept border, removed dark:bg --}}
                <div class="px-4">
                    {{-- Removed text color classes --}}
                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    {{-- Requires changes inside x-responsive-nav-link component --}}
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else {{-- Responsive Guest Links --}}
        <div class="pt-4 pb-1 border-t border-gray-200"> {{-- Kept border --}}
            <div class="mt-3 space-y-1">
                {{-- Requires changes inside x-responsive-nav-link component --}}
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
        @endauth
    </div>
</nav>
