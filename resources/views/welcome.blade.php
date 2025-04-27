<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <x-application-logo class="block h-12 w-auto text-gray-800 dark:text-white"/>
        </div>

        <div class="mt-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Welcome to Our Store!</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                Your best source for amazing products.
            </p>

            <div class="mt-8 space-x-4">
                <a href="{{ route('login') }}" class="text-lg font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-lg font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
