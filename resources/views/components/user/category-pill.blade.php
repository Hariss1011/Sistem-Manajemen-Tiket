@props(['active' => false, 'label' => '', 'href' => '#'])

<a href="{{ $href }}" @if ($active) aria-current="true" @endif
    {{ $attributes->merge([
        'class' =>
            'btn btn-sm shrink-0 rounded-full px-4 font-semibold ' .
            ($active ? 'btn-primary' : 'border-base-300 bg-base-100 hover:border-primary hover:text-primary'),
    ]) }}>
    {{ $label }}
</a>
