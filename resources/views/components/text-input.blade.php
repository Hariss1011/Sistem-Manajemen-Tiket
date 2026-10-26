@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input w-full bg-base-100']) }}>
