<a {{ $attributes->merge([
    'class' => 'block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-150'
]) }}>
    {{ $slot }}
</a>
