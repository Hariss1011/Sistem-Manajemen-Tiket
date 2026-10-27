<header x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-18 items-center justify-between gap-4">

            {{-- Brand --}}
            <a href="{{ route('home') }}" aria-label="BengTix, ke beranda"
                class="group flex shrink-0 items-center rounded-xl outline-none focus-visible:ring-4 focus-visible:ring-blue-100">
                <x-brand />
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden h-full items-center gap-1 md:flex" aria-label="Menu utama">
                <a href="{{ route('home') }}#jelajah" @if (request()->routeIs('home', 'events.*')) aria-current="page" @endif
                    class="relative inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold transition duration-200
                    {{ request()->routeIs('home', 'events.*')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' }}">
                    <x-icon name="compass" class="size-4.5" />
                    Jelajahi Acara

                    @if (request()->routeIs('home', 'events.*'))
                        <span class="absolute inset-x-4 -bottom-4.25 h-0.5 rounded-full bg-blue-600"></span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('orders.index') }}" @if (request()->routeIs('orders.*')) aria-current="page" @endif
                        class="relative inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold transition duration-200
                        {{ request()->routeIs('orders.*')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' }}">
                        <x-icon name="ticket" class="size-4.5" />
                        Pesanan Saya

                        @if (request()->routeIs('orders.*'))
                            <span class="absolute inset-x-4 -bottom-4.25 h-0.5 rounded-full bg-blue-600"></span>
                        @endif
                    </a>
                @endauth
            </nav>

            {{-- Account Actions --}}
            <div class="ml-auto hidden shrink-0 items-center gap-3 md:flex">

                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex h-10 items-center justify-center rounded-xl px-4 text-sm font-semibold text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                        class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-md shadow-blue-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/25 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-200">
                        <x-icon name="user-round-plus" class="size-4" />
                        Daftar
                    </a>
                @endguest

                @auth
                    <div class="mx-1 h-8 w-px bg-slate-200"></div>

                    {{-- User Dropdown --}}
                    <div class="dropdown dropdown-end">
                        <button type="button" tabindex="0" aria-label="Menu akun {{ Auth::user()->name }}"
                            class="group inline-flex max-w-60 items-center gap-3 rounded-2xl border border-transparent py-1.5 pl-1.5 pr-3 text-left transition duration-200 hover:border-slate-200 hover:bg-slate-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100">
                            <span
                                class="grid size-10 shrink-0 place-items-center rounded-xl bg-linear-to-br from-blue-600 to-indigo-700 text-sm font-extrabold uppercase text-white shadow-sm shadow-blue-600/20">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                            </span>

                            <span class="min-w-0">
                                <span class="block max-w-32 truncate text-sm font-bold text-slate-800">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="mt-0.5 block text-[11px] font-medium text-slate-500">
                                    Akun Saya
                                </span>
                            </span>

                            <x-icon name="chevron-down"
                                class="size-4 shrink-0 text-slate-400 transition duration-200 group-hover:text-slate-700" />
                        </button>

                        <ul tabindex="0"
                            class="menu dropdown-content z-50 mt-3 w-64 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10">
                            {{-- User Information --}}
                            <li class="pointer-events-none mb-1 border-b border-slate-100 px-3 py-3">
                                <span class="px-0! py-0! text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                    Akun Aktif
                                </span>
                                <span class="mt-1 block px-0! py-0! text-sm font-bold text-slate-900">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="mt-1 block px-0! py-0! text-xs font-normal text-slate-500">
                                    {{ Auth::user()->email }}
                                </span>
                            </li>

                            <li>
                                <a href="{{ route('orders.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                    <x-icon name="ticket" class="size-4" />
                                    Pesanan Saya
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                    <x-icon name="user-round" class="size-4" />
                                    Profil Saya
                                </a>
                            </li>

                            @if (Auth::user()->isAdmin())
                                <li class="mt-1 border-t border-slate-100 pt-1">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold text-blue-700 transition hover:bg-blue-50">
                                        <x-icon name="layout-dashboard" class="size-4" />
                                        Panel Admin
                                        <x-icon name="arrow-up-right" class="ml-auto size-3.5" />
                                    </a>
                                </li>
                            @endif

                            <li class="mt-1 border-t border-slate-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-200">
                                        <x-icon name="log-out" class="size-4" />
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>

            {{-- Mobile Menu Toggle --}}
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen.toString()"
                aria-controls="user-mobile-navigation"
                :aria-label="mobileMenuOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'"
                class="inline-flex size-11 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100 md:hidden">
                <x-icon x-show="!mobileMenuOpen" name="menu" class="size-5" />

                <x-icon x-show="mobileMenuOpen" x-cloak name="x" class="size-5" />
            </button>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div id="user-mobile-navigation" x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-slate-200 bg-white shadow-lg shadow-slate-900/5 md:hidden">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6">

            {{-- Main Menu --}}
            <nav class="space-y-1" aria-label="Navigasi mobile">
                <a href="{{ route('home') }}#jelajah"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                    {{ request()->routeIs('home', 'events.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">
                    <x-icon name="compass" class="size-4.5" />
                    Jelajahi Acara

                    @if (request()->routeIs('home', 'events.*'))
                        <span class="ml-auto size-2 rounded-full bg-blue-600"></span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('orders.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                        {{ request()->routeIs('orders.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <x-icon name="ticket" class="size-4.5" />
                        Pesanan Saya

                        @if (request()->routeIs('orders.*'))
                            <span class="ml-auto size-2 rounded-full bg-blue-600"></span>
                        @endif
                    </a>
                @endauth
            </nav>

            {{-- Guest Actions --}}
            @guest
                <div class="mt-4 grid grid-cols-2 gap-3 border-t border-slate-100 pt-4">
                    <a href="{{ route('login') }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-bold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700">
                        <x-icon name="user-round-plus" class="size-4" />
                        Daftar
                    </a>
                </div>
            @endguest

            {{-- Authenticated User Actions --}}
            @auth
                <div class="mt-4 border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3">
                        <span
                            class="grid size-11 shrink-0 place-items-center rounded-xl bg-linear-to-br from-blue-600 to-indigo-700 text-sm font-extrabold uppercase text-white">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-slate-900">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="truncate text-xs text-slate-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-2 space-y-1">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            <x-icon name="user-round" class="size-4" />
                            Profil Saya
                        </a>

                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                <x-icon name="layout-dashboard" class="size-4" />
                                Panel Admin
                                <x-icon name="arrow-up-right" class="ml-auto size-4" />
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                <x-icon name="log-out" class="size-4" />
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
