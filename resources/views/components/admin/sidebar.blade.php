<div class="drawer-side z-40">
    <label for="my-drawer-4" aria-label="Tutup sidebar" class="drawer-overlay"></label>

    <aside
        class="flex min-h-full w-72 flex-col border-r border-white/10 bg-[#101828] text-slate-300 shadow-2xl shadow-slate-950/10">

        {{-- Brand --}}
        <div class="border-b border-white/8 px-5 py-6">
            <a href="{{ route('home') }}" aria-label="BengTix, kembali ke situs"
                class="group flex items-center gap-3 rounded-xl">
                <span
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-950/30 transition group-hover:bg-blue-500">
                    <svg viewBox="0 0 32 32" fill="none" class="size-6" aria-hidden="true">
                        <path
                            d="M6 6.5h20a2 2 0 0 1 2 2v4a3.5 3.5 0 0 0 0 7v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4a3.5 3.5 0 0 0 0-7v-4a2 2 0 0 1 2-2Z"
                            fill="currentColor" />
                        <path d="M19.5 10v12" stroke="#93C5FD" stroke-width="2" stroke-linecap="round"
                            stroke-dasharray="1 3.5" />
                    </svg>
                </span>

                <span class="min-w-0">
                    <span class="block text-xl font-extrabold tracking-tight text-white">
                        Beng<span class="text-blue-400">Tix</span>
                    </span>
                    <span class="mt-1 block text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        Ticket Management
                    </span>
                </span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav aria-label="Navigasi admin" class="flex-1 px-3 py-6">
            <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                Menu utama
            </p>

            <ul class="space-y-1.5">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.dashboard'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.dashboard'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="9" rx="1.5" />
                            <rect x="14" y="3" width="7" height="5" rx="1.5" />
                            <rect x="14" y="12" width="7" height="9" rx="1.5" />
                            <rect x="3" y="16" width="7" height="5" rx="1.5" />
                        </svg>
                        <span>Dashboard</span>
                        @if (request()->routeIs('admin.dashboard'))
                            <span class="ml-auto size-1.5 rounded-full bg-white"></span>
                        @endif
                    </a>
                </li>

                {{-- Categories --}}
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.categories.*'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.categories.*'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                            <rect x="3" y="3" width="8" height="8" rx="2" />
                            <rect x="13" y="3" width="8" height="5" rx="2" />
                            <rect x="13" y="10" width="8" height="11" rx="2" />
                            <rect x="3" y="13" width="8" height="8" rx="2" />
                        </svg>
                        <span>Manajemen Kategori</span>
                    </a>
                </li>

                {{-- Ticket types --}}
                <li>
                    <a href="{{ route('admin.tipe_tiket.index') }}"
                        @if (request()->routeIs('admin.tipe_tiket.*')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.tipe_tiket.*'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.tipe_tiket.*'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                            <path d="M4 6h16M9 3v3M9 21v-3" />
                            <path d="M12 10h4M12 14h4" />
                        </svg>
                        <span>Manajemen Tipe Tiket</span>
                    </a>
                </li>

                {{-- Locations --}}
                <li>
                    <a href="{{ route('admin.lokasis.index') }}"
                        @if (request()->routeIs('admin.lokasis.*')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.lokasis.*'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.lokasis.*'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                            <circle cx="12" cy="10" r="2.5" />
                        </svg>
                        <span>Manajemen Lokasi</span>
                    </a>
                </li>

                {{-- Events --}}
                <li>
                    <a href="{{ route('admin.events.index') }}"
                        @if (request()->routeIs('admin.events.*')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.events.*'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.events.*'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                            <path d="m9 15 2 2 4-4" />
                        </svg>
                        <span>Manajemen Event</span>
                    </a>
                </li>

                {{-- Purchase history --}}
                <li>
                    <a href="{{ route('admin.histories.index') }}"
                        @if (request()->routeIs('admin.histories.*')) aria-current="page" @endif @class([
                            'group flex min-h-11 items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition duration-200',
                            'bg-blue-600 text-white shadow-lg shadow-blue-950/30' => request()->routeIs(
                                'admin.histories.*'),
                            'text-slate-400 hover:bg-white/[0.06] hover:text-white' => !request()->routeIs(
                                'admin.histories.*'),
                        ])>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0"
                            aria-hidden="true">
                            <path d="M3 12a9 9 0 1 0 2.6-6.4L3 8" />
                            <path d="M3 3v5h5" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                        <span>History Pembelian</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Admin identity and logout --}}
        <div class="mt-auto border-t border-white/8 p-4">
            <div class="mb-3 flex items-center gap-3 rounded-xl border border-white/6 bg-white/4 p-3">
                <span
                    class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-blue-500/15 text-sm font-extrabold text-blue-300 ring-1 ring-blue-400/20">
                    A
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">BengTix Admin</p>
                    <p class="mt-0.5 text-xs text-slate-500">Pengelolaan platform</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex min-h-11 w-full items-center gap-3 rounded-xl border border-rose-400/15 px-3.5 py-3 text-sm font-semibold text-rose-300 transition duration-200 hover:border-rose-400/30 hover:bg-rose-500/10 hover:text-rose-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-400">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0" aria-hidden="true">
                        <path d="M10 17l5-5-5-5M15 12H3" />
                        <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
                    </svg>
                    <span>Keluar dari akun</span>
                </button>
            </form>

            <p class="pt-4 text-center text-[10px] font-medium tracking-wide text-slate-600">
                BENGTIX &copy; {{ now()->year }}
            </p>
        </div>
    </aside>
</div>
