<!DOCTYPE html>
<html lang="id" data-theme="bengtix">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BengTix') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">
        <a href="{{ route('home') }}" aria-label="BengTix, ke beranda" class="rounded-lg">
            <x-brand />
        </a>

        <div class="mt-6 w-full max-w-md rounded-box border border-base-300 bg-base-100 p-6 sm:p-8">
            {{ $slot }}
        </div>

        <a href="{{ route('home') }}" class="link link-hover mt-6 text-sm text-base-content/70">Kembali ke beranda</a>
    </div>
</body>

</html>
