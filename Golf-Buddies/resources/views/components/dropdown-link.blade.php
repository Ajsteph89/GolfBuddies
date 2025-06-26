<a {{ $attributes->merge([
    'class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-green-900 hover:bg-green-300 focus:outline-none focus:bg-green-300 transition duration-150 ease-in-out hover:text-yellow-500 focus:text-yellow-500'
]) }}>
    {{ $slot }}
</a>
