<!DOCTYPE html>
<html lang="id" data-theme="bengtix">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="BengTix: temukan konser, seminar, dan workshop, lalu pesan tiketnya dalam beberapa langkah.">

    <title>{{ isset($title) ? $title . ' · ' : '' }}{{ config('app.name', 'BengTix') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col font-sans">
    <a href="#konten"
        class="sr-only z-50 rounded-lg bg-base-100 px-4 py-2 font-semibold focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Lompat ke konten
    </a>

    @include('components.user.navigation')

    @isset($header)
        <header class="border-b border-base-300 bg-base-100">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    <x-footer />

    @if (session('success') || session('status'))
        <div class="toast toast-end toast-bottom z-50" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            x-cloak x-transition.opacity role="status">
            <div class="alert alert-success shadow-lg">
                <x-icon name="check" class="size-5" />
                <span>{{ session('success') ?? session('status') }}</span>
            </div>
        </div>
    @endif
</body>

</html>
