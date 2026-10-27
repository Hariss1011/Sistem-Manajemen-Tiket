<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'btn border-0 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold shadow-md shadow-blue-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg hover:shadow-blue-600/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 active:translate-y-0 disabled:pointer-events-none disabled:opacity-50',
    ]) }}>
    {{ $slot }}
</button>
