<nav x-data="{ open: false }"
    class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-19 items-center justify-between">

            {{-- Brand --}}
            <div class="flex min-w-0 items-center">
                <a href="{{ route('dashboard') }}"
                    class="group flex shrink-0 items-center gap-3 rounded-xl outline-none focus-visible:ring-4 focus-visible:ring-blue-100"
                    aria-label="BengTix Dashboard">
                    <div
                        class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-blue-600 shadow-lg shadow-blue-600/20 transition duration-200 group-hover:-translate-y-0.5 group-hover:bg-blue-700">
                        <x-application-logo class="block h-7 w-7 fill-current text-white" />
                    </div>

                    <div class="hidden min-w-0 sm:block">
                        <span class="block text-lg font-extrabold leading-tight tracking-tight text-slate-900">
                            Beng<span class="text-blue-600">Tix</span>
                        </span>
                        <span class="mt-1 block text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">
                            Event Management
                        </span>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <div class="ml-8 hidden items-center sm:flex lg:ml-12">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="inline-flex! items-center! rounded-xl! px-4! py-2.5! text-sm! font-semibold! transition duration-200">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <rect x="3.5" y="3.5" width="7" height="7" rx="1.5" />
                            <rect x="13.5" y="3.5" width="7" height="7" rx="1.5" />
                            <rect x="3.5" y="13.5" width="7" height="7" rx="1.5" />
                            <rect x="13.5" y="13.5" width="7" height="7" rx="1.5" />
                        </svg>
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            {{-- Desktop User Menu --}}
            <div class="hidden items-center sm:flex">
                <div class="mr-4 hidden h-9 w-px bg-slate-200 md:block"></div>

                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button type="button"
                            class="group inline-flex max-w-65 items-center gap-3 rounded-2xl border border-transparent px-3 py-2 text-left transition duration-200 hover:border-slate-200 hover:bg-slate-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100"
                            aria-label="Buka menu akun">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-extrabold uppercase text-blue-700 ring-1 ring-blue-100 transition group-hover:bg-blue-100">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <div class="hidden min-w-0 lg:block">
                                <p class="max-w-37.5 truncate text-sm font-bold text-slate-800">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Akun pengguna
                                </p>
                            </div>

                            <svg class="h-4 w-4 shrink-0 text-slate-400 transition duration-200 group-hover:text-slate-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Akun Anda
                            </p>
                            <p class="mt-1 truncate text-sm font-bold text-slate-800">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="mt-1 break-all text-xs text-slate-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <div class="p-1.5">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-xl! px-3! py-2.5! text-sm!">
                                <span class="flex items-center gap-3">
                                    <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="8" r="3.5" />
                                        <path d="M5 20a7 7 0 0 1 14 0" />
                                    </svg>
                                    Pengaturan Profil
                                </span>
                            </x-dropdown-link>

                            <div class="my-1 border-t border-slate-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-200">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M10 17l5-5-5-5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 12H3" stroke-linecap="round" />
                                        <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" stroke-linecap="round" />
                                    </svg>
                                    Keluar dari Akun
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex items-center sm:hidden">
                <button type="button" @click="open = !open" :aria-expanded="open.toString()"
                    aria-controls="mobile-navigation" aria-label="Buka atau tutup navigasi"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-100">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" />
                    </svg>

                    <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m6 6 12 12M18 6 6 18" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div id="mobile-navigation" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-slate-100 bg-white px-4 pb-5 pt-3 shadow-lg shadow-slate-900/5 sm:hidden">
        <div class="space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <div class="my-4 border-t border-slate-100"></div>

        {{-- Mobile Account Summary --}}
        <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-extrabold uppercase text-blue-700">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-bold text-slate-800">
                    {{ Auth::user()->name }}
                </p>
                <p class="truncate text-xs text-slate-500">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                Pengaturan Profil
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="flex w-full items-center rounded-xl px-4 py-3 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-200">
                    <svg class="mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M10 17l5-5-5-5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 12H3" stroke-linecap="round" />
                        <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" stroke-linecap="round" />
                    </svg>
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </div>
</nav>
