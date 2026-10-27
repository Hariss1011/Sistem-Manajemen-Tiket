@props(['active' => false, 'label' => '', 'href' => '#'])

<a href="{{ $href }}" @if ($active) aria-current="true" @endif
    {{ $attributes->merge([
        'class' =>
            'btn btn-sm min-h-9 shrink-0 rounded-full border px-4 font-semibold normal-case transition-all duration-200 ' .
            ($active
                ? 'border-blue-600 bg-blue-600 text-white shadow-md shadow-blue-600/20 hover:border-blue-700 hover:bg-blue-700'
                : 'border-slate-200 bg-white text-slate-600 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700'),
    ]) }}>
    {{ $label }}
</a>
