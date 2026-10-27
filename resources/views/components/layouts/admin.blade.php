<!DOCTYPE html>
<html lang="id" data-theme="bengtix">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($title ?? 'Panel Admin') . ' · ' . config('app.name', 'BengTix') }}</title>
    <meta name="theme-color" content="#101828">
    <meta name="description"
        content="Panel administrasi BengTix untuk mengelola event, tiket, lokasi, kategori, dan transaksi.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F4F7FB] font-sans text-slate-800 antialiased">

    <div class="drawer min-h-screen w-full lg:drawer-open">

        {{-- Checkbox pengendali drawer mobile --}}
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle">

        {{-- Konten utama --}}
        <div class="drawer-content flex min-h-screen min-w-0 flex-col">

            {{-- Top navigation --}}
            <header
                class="sticky top-0 z-30 flex h-18 items-center gap-3 border-b border-slate-200/80 bg-white/95 px-4 shadow-sm shadow-slate-900/2 backdrop-blur-md sm:px-6 lg:px-8">

                {{-- Mobile menu button --}}
                <label for="my-drawer-4" aria-label="Buka menu navigasi"
                    class="btn btn-square btn-ghost rounded-xl text-slate-600 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="size-5"
                        aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>

                {{-- Page context --}}
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-extrabold tracking-tight text-slate-800 sm:text-base">
                        Panel Administrasi
                    </p>
                    <p class="mt-0.5 hidden truncate text-xs text-slate-500 sm:block">
                        Kelola event dan transaksi tiket BengTix
                    </p>
                </div>

                {{-- System status --}}
                <div
                    class="hidden items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3.5 py-2 sm:flex">
                    <span class="relative flex size-2">
                        <span
                            class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-50"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-bold text-emerald-700">BengTix aktif</span>
                </div>

                {{-- Admin avatar --}}
                <div
                    class="flex size-9 items-center justify-center rounded-xl bg-blue-50 text-sm font-extrabold text-blue-700 ring-1 ring-blue-100">
                    A
                </div>
            </header>

            {{-- Page content --}}
            <main class="w-full min-w-0 flex-1 px-4 py-5 sm:px-6 sm:py-7 lg:px-8 lg:py-8">
                {{ $slot }}
            </main>

        </div>

        {{-- Sidebar --}}
        @include('components.admin.sidebar')

    </div>

    @stack('scripts')
</body>

</html>
