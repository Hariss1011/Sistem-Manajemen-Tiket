<!DOCTYPE html>
<html lang="id" data-theme="bengtix">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
        content="BengTix: temukan konser, seminar, dan workshop, lalu pesan tiketnya dalam beberapa langkah.">

    <meta name="theme-color" content="#101828">

    <title>
        {{ isset($title) ? $title . ' · ' : '' }}{{ config('app.name', 'BengTix') }}
    </title>

    {{-- Typography --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    {{-- Application Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-800 antialiased selection:bg-blue-100 selection:text-blue-900">

    {{-- Accessibility: Skip to Main Content --}}
    <a href="#konten"
        class="sr-only z-100 rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white shadow-lg focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:outline-none focus:ring-4 focus:ring-blue-200">
        Lompat ke konten
    </a>

    {{-- Public Navigation --}}
    <div class="relative z-40 shrink-0">
        @include('components.user.navigation')
    </div>

    {{-- Optional Page Header --}}
    @isset($header)
        <section class="relative overflow-hidden border-b border-slate-200 bg-white">
            <div aria-hidden="true"
                class="pointer-events-none absolute inset-y-0 right-0 w-1/3 bg-linear-to-l from-blue-50/80 to-transparent">
            </div>

            <div class="relative mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                {{ $header }}
            </div>
        </section>
    @endisset

    {{-- Main Page Content --}}
    <main id="konten" class="relative min-w-0 flex-1">
        {{ $slot }}
    </main>

    {{-- Global Footer --}}
    <div class="mt-auto">
        <x-footer />
    </div>

    {{-- Success / Status Notification --}}
    @if (session('success') || session('status'))
        <div class="toast toast-end toast-bottom z-100 max-w-[calc(100vw-2rem)]" x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-3 opacity-0" role="status" aria-live="polite">
            <div
                class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-white px-4 py-3.5 text-slate-800 shadow-xl shadow-slate-900/10">
                <div class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50">
                    <x-icon name="check-circle" class="size-5 text-emerald-600" />
                </div>

                <div class="min-w-0 flex-1 pt-0.5">
                    <p class="text-sm font-bold text-slate-900">
                        Berhasil
                    </p>

                    <p class="mt-1 wrap-break-word text-sm leading-relaxed text-slate-600">
                        {{ session('success') ?? session('status') }}
                    </p>
                </div>

                <button type="button" @click="show = false" aria-label="Tutup notifikasi"
                    class="flex size-7 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <x-icon name="x" class="size-4" />
                </button>
            </div>
        </div>
    @endif

</body>

</html>
