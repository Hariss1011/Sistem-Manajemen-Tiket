@props(['name', 'class' => 'size-4'])

@php
    $paths = [
        'calendar' =>
            'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5',

        'clock' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',

        'pin' =>
            'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',

        'chevron' => 'm8.25 4.5 7.5 7.5-7.5 7.5',
        'chevron-down' => 'm6 9 6 6 6-6',
        'search' => 'm21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z',

        'user' =>
            'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',

        'user-round' =>
            'M18 20a6 6 0 0 0-12 0m12 0H6m12 0h3v-1a4 4 0 0 0-3-3.87M6 20H3v-1a4 4 0 0 1 3-3.87m9-7.13a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2a2 2 0 1 0-2-2',

        'user-round-plus' =>
            'M18 20a6 6 0 0 0-12 0m12 0H6m12 0h3v-1a4 4 0 0 0-3-3.87M6 20H3v-1a4 4 0 0 1 3-3.87m9-7.13a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm5 0v6m3-3h-6',

        'ticket' =>
            'M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z',

        'compass' =>
            'm15.59 14.37-2.53-7.59a1.12 1.12 0 0 0-2.12 0l-2.53 7.59a1.12 1.12 0 0 0 1.42 1.42l7.59-2.53a1.12 1.12 0 0 0 0-2.12l-7.59-2.53a1.12 1.12 0 0 0-1.42 1.42Z M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z',

        'layout-dashboard' => 'M3 3h8v8H3zM13 3h8v5h-8zM13 10h8v11h-8zM3 13h8v8H3z',

        'menu' => 'M4 6h16M4 12h16M4 18h16',
        'x' => 'M6 6l12 12M18 6 6 18',
        'log-out' => 'M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5m5 5H3',

        'check' => 'm4.5 12.75 6 6 9-13.5',
        'check-circle' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',

        'plus' => 'M12 4.5v15m7.5-7.5h-15',
        'minus' => 'M5 12h14',
    ];

    $path = $paths[$name] ?? null;
@endphp

@if ($path)
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
        {{ $attributes->merge(['class' => $class]) }} aria-hidden="true" focusable="false">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}" />
    </svg>
@else
    {{-- Fallback: ikon sederhana jika nama belum terdaftar --}}
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
        {{ $attributes->merge(['class' => $class]) }} aria-hidden="true" focusable="false">
        <circle cx="12" cy="12" r="9" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
    </svg>
@endif
