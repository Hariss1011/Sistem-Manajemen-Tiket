<!DOCTYPE html>
<html lang="id" data-theme="bengtix">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BengTix') }}</title>

    <meta name="description" content="BengTix — platform pengelolaan dan pemesanan tiket acara.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 font-sans antialiased text-slate-800">

    <main
        class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">

        {{-- Background Decoration --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>
            <div class="absolute -right-32 top-1/4 h-96 w-96 rounded-full bg-indigo-200/30 blur-3xl"></div>
            <div class="absolute -bottom-40 left-1/4 h-96 w-96 rounded-full bg-sky-100/70 blur-3xl"></div>

            <div class="absolute inset-0 opacity-[0.035]"
                style="background-image: radial-gradient(#334155 1px, transparent 1px); background-size: 24px 24px;">
            </div>
        </div>

        <div class="relative z-10 flex w-full max-w-md flex-col items-center">

            {{-- Brand --}}
            <a href="{{ route('home') }}" aria-label="BengTix, ke beranda"
                class="group mb-8 flex flex-col items-center rounded-2xl outline-none focus-visible:ring-4 focus-visible:ring-blue-200">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 shadow-xl shadow-blue-600/25 ring-1 ring-blue-500/20 transition duration-200 group-hover:-translate-y-1 group-hover:bg-blue-700">
                        <x-application-logo class="block h-9 w-9 fill-current text-white" />
                    </div>

                    <div class="text-left">
                        <span class="block text-3xl font-extrabold tracking-tight text-slate-900">
                            Beng<span class="text-blue-600">Tix</span>
                        </span>
                        <span class="mt-1 block text-[10px] font-bold uppercase tracking-[0.22em] text-slate-500">
                            Your Event Experience
                        </span>
                    </div>
                </div>
            </a>

            {{-- Authentication Card --}}
            <section
                class="w-full overflow-hidden rounded-3xl border border-white/80 bg-white/95 shadow-2xl shadow-slate-900/[0.07] ring-1 ring-slate-900/4 backdrop-blur-xl">

                {{-- Top Accent --}}
                <div class="h-1.5 w-full bg-linear-to-r from-blue-700 via-blue-500 to-sky-400"></div>

                <div class="p-6 sm:p-9">
                    {{ $slot }}
                </div>

                {{-- Card Footer --}}
                <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-4 text-center sm:px-9">
                    <p class="text-xs leading-5 text-slate-500">
                        Pengalaman acara yang lebih mudah,
                        <span class="font-semibold text-slate-700">bersama BengTix.</span>
                    </p>
                </div>
            </section>

            {{-- Back to Homepage --}}
            <a href="{{ route('home') }}"
                class="group mt-7 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold text-slate-500 transition duration-200 hover:bg-white/80 hover:text-blue-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100">
                <svg class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path d="M19 12H5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="m12 19-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Kembali ke beranda
            </a>

            {{-- Copyright --}}
            <p class="mt-5 text-center text-[11px] font-medium tracking-wide text-slate-400">
                &copy; {{ date('Y') }} BengTix. Semua hak dilindungi.
            </p>
        </div>
    </main>

</body>

</html>
