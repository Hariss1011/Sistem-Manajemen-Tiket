<x-layouts.app>
    {{-- Hero Section --}}
    <section class="relative isolate overflow-hidden border-b border-slate-200 bg-white">
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -right-24 -top-32 size-96 rounded-full bg-blue-100/70 blur-3xl"></div>
            <div class="absolute -left-32 bottom-0 size-80 rounded-full bg-indigo-50/80 blur-3xl"></div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#94a3b8_1px,transparent_1px),linear-gradient(to_bottom,#94a3b8_1px,transparent_1px)] bg-size-[48px_48px] opacity-[0.08]">
            </div>
        </div>

        <div
            class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-14 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16 lg:px-8 lg:py-24">

            {{-- Hero Content --}}
            <div class="relative">
                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-700 sm:text-sm">
                    <span class="relative flex size-2">
                        <span
                            class="absolute inline-flex size-full animate-ping rounded-full bg-blue-400 opacity-60"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-blue-600"></span>
                    </span>
                    Temukan pengalaman berikutnya
                </div>

                <h1
                    class="max-w-2xl text-4xl font-extrabold leading-[1.12] tracking-tight text-slate-950 text-balance sm:text-5xl lg:text-6xl">
                    Setiap acara punya cerita.
                    <span
                        class="mt-1 block bg-linear-to-r from-blue-600 via-blue-700 to-indigo-600 bg-clip-text text-transparent">
                        Mulai ceritamu di sini.
                    </span>
                </h1>

                <p class="mt-6 max-w-xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8">
                    Temukan konser, seminar, dan workshop menarik di satu tempat.
                    Pilih acara favoritmu dan amankan tiketnya dengan mudah.
                </p>

                {{-- Search Form --}}
                <form method="GET" action="{{ route('home') }}#jelajah" role="search"
                    class="mt-8 flex max-w-xl flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg shadow-slate-900/5 sm:flex-row sm:items-center">

                    <label class="flex min-h-12 flex-1 items-center gap-3 px-3">
                        <x-icon name="search" class="size-5 shrink-0 text-slate-400" />
                        <input type="search" name="q" value="{{ $q }}"
                            class="min-w-0 flex-1 border-0 bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:outline-none focus:ring-0"
                            placeholder="Cari nama acara atau lokasi" aria-label="Cari acara">
                    </label>

                    <button type="submit"
                        class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-bold text-white shadow-sm shadow-blue-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md hover:shadow-blue-600/25 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-icon name="search" class="size-4" />
                        Cari acara
                    </button>
                </form>

                {{-- Summary --}}
                <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-3 text-sm text-slate-500">
                    <span class="inline-flex items-center gap-2">
                        <x-icon name="calendar-days" class="size-4 text-blue-600" />
                        <strong class="font-bold text-slate-900">{{ $totalUpcoming }}</strong>
                        acara akan datang
                    </span>
                    <span class="hidden h-4 w-px bg-slate-200 sm:block"></span>
                    <span class="inline-flex items-center gap-2">
                        <x-icon name="shield-check" class="size-4 text-blue-600" />
                        Pemesanan praktis dalam satu tempat
                    </span>
                </div>
            </div>

            {{-- Featured Event --}}
            @if ($featured)
                @php
                    $fd = $featured->tanggal_waktu->copy()->locale('id');
                    $fmin = $featured->tikets_min_harga;
                @endphp

                <div class="relative mx-auto w-full max-w-lg lg:ml-auto">
                    <div
                        class="absolute -inset-3 -rotate-2 rounded-4xl bg-linear-to-br from-blue-200/70 via-indigo-100/70 to-sky-100/70">
                    </div>

                    <a href="{{ route('events.show', $featured) }}"
                        class="group relative block overflow-hidden rounded-[1.6rem] border border-slate-200/80 bg-white shadow-2xl shadow-slate-900/10 transition duration-300 hover:-translate-y-1 hover:shadow-blue-900/10"
                        aria-label="Acara unggulan: {{ $featured->judul }}">

                        <div class="relative aspect-16/10 overflow-hidden bg-slate-100">
                            <img src="{{ $featured->gambar_url }}" alt="{{ $featured->judul }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                                class="size-full object-cover transition duration-700 group-hover:scale-105">

                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-slate-950/10 to-transparent">
                            </div>

                            <span
                                class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full border border-white/30 bg-slate-950/65 px-3 py-1.5 text-xs font-bold text-white shadow-sm backdrop-blur-md">
                                <x-icon name="sparkles" class="size-3.5" />
                                Acara unggulan
                            </span>

                            <div class="absolute inset-x-5 bottom-5 text-white sm:inset-x-6 sm:bottom-6">
                                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-blue-200">
                                    Pilihan untukmu
                                </p>
                                <h2 class="line-clamp-2 text-2xl font-extrabold leading-tight text-balance sm:text-3xl">
                                    {{ $featured->judul }}
                                </h2>
                            </div>
                        </div>

                        <div class="space-y-4 p-5 sm:p-6">
                            <div class="flex items-start gap-3">
                                <span
                                    class="grid size-10 shrink-0 place-items-center rounded-xl bg-blue-50 text-blue-700">
                                    <x-icon name="calendar-days" class="size-5" />
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-slate-500">Waktu acara</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-800">
                                        {{ $fd->translatedFormat('l, d F Y · H.i') }} WIB
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <span
                                    class="grid size-10 shrink-0 place-items-center rounded-xl bg-blue-50 text-blue-700">
                                    <x-icon name="map-pin" class="size-5" />
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-slate-500">Lokasi acara</p>
                                    <p class="mt-1 truncate text-sm font-semibold text-slate-800">
                                        {{ $featured->lokasi?->nama_lokasi ?? 'Lokasi belum ditentukan' }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex flex-wrap items-center justify-between gap-4 border-t border-dashed border-slate-200 pt-5">
                                <div>
                                    <p class="text-xs font-medium text-slate-500">
                                        @if (!is_null($fmin) && (float) $fmin === 0.0)
                                            Harga tiket
                                        @elseif (!is_null($fmin) && (float) $fmin > 0)
                                            Mulai dari
                                        @else
                                            Informasi tiket
                                        @endif
                                    </p>

                                    <p class="mt-1 text-lg font-extrabold text-slate-950 sm:text-xl">
                                        @if (is_null($fmin))
                                            Tiket belum dibuka
                                        @elseif ((float) $fmin === 0.0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($fmin, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </div>

                                <span
                                    class="inline-flex min-h-11 items-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-bold text-white transition-colors group-hover:bg-blue-700">
                                    Lihat acara
                                    <x-icon name="arrow-up-right"
                                        class="size-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @else
                <div
                    class="relative flex min-h-72 items-center justify-center overflow-hidden rounded-[1.6rem] border border-slate-200 bg-white p-8 text-center shadow-xl shadow-slate-900/4">
                    <div class="max-w-sm">
                        <span class="mx-auto grid size-14 place-items-center rounded-2xl bg-blue-50 text-blue-600">
                            <x-icon name="calendar-days" class="size-7" />
                        </span>
                        <h2 class="mt-5 text-xl font-bold text-slate-900">
                            Acara unggulan segera hadir
                        </h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Jelajahi daftar acara yang tersedia dan temukan pengalaman menarik berikutnya.
                        </p>
                        <a href="#jelajah"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700">
                            Jelajahi acara
                            <x-icon name="arrow-down" class="size-4" />
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- Event Exploration --}}
    <section id="jelajah" class="scroll-mt-24 bg-slate-50/80">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">

            {{-- Section Heading --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div
                        class="mb-3 inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-blue-600">
                        <span class="h-px w-6 bg-blue-600"></span>
                        Temukan favoritmu
                    </div>

                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">
                        {{ $selesai ? 'Acara yang sudah selesai' : 'Acara akan datang' }}
                    </h2>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">
                        {{ $selesai
                            ? 'Lihat kembali acara yang telah berlangsung.'
                            : 'Jelajahi berbagai pilihan acara dan temukan yang paling sesuai untukmu.' }}
                    </p>
                </div>

                {{-- Event Status Tabs --}}
                <div role="tablist" aria-label="Status acara"
                    class="inline-flex w-fit items-center rounded-xl border border-slate-200 bg-white p-1 shadow-sm">

                    <a role="tab" aria-selected="{{ !$selesai ? 'true' : 'false' }}"
                        href="{{ route('home', array_filter(['q' => $q, 'kategori' => request('kategori'), 'lokasi' => request('lokasi'), 'urut' => request('urut')])) }}#jelajah"
                        class="inline-flex min-h-10 items-center rounded-lg px-4 text-sm font-semibold transition-all
                        {{ !$selesai ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Akan datang
                    </a>

                    <a role="tab" aria-selected="{{ $selesai ? 'true' : 'false' }}"
                        href="{{ route('home', array_filter(['status' => 'selesai', 'q' => $q, 'kategori' => request('kategori'), 'lokasi' => request('lokasi'), 'urut' => request('urut')])) }}#jelajah"
                        class="inline-flex min-h-10 items-center rounded-lg px-4 text-sm font-semibold transition-all
                        {{ $selesai ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Sudah selesai
                    </a>
                </div>
            </div>

            {{-- Category and Filters --}}
            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm shadow-slate-900/2 sm:p-5">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                    {{-- Category Pills --}}
                    <nav class="-mx-1 flex min-w-0 gap-2 overflow-x-auto px-1 pb-1" aria-label="Filter kategori">

                        @php
                            $base = array_filter([
                                'q' => $q,
                                'status' => $selesai ? 'selesai' : null,
                                'lokasi' => request('lokasi'),
                                'urut' => request('urut'),
                            ]);
                        @endphp

                        <x-user.category-pill label="Semua" :href="route('home', $base) . '#jelajah'" :active="!request('kategori')" />

                        @foreach ($categories as $kategori)
                            <x-user.category-pill :label="$kategori->nama" :href="route('home', $base + ['kategori' => $kategori->id]) . '#jelajah'" :active="(string) request('kategori') === (string) $kategori->id" />
                        @endforeach
                    </nav>

                    {{-- Location and Sort Filters --}}
                    <form method="GET" action="{{ route('home') }}#jelajah"
                        class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:w-auto xl:shrink-0">

                        @foreach (array_filter([
        'q' => $q,
        'status' => $selesai ? 'selesai' : null,
        'kategori' => request('kategori'),
    ]) as $name => $value)
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endforeach

                        <label
                            class="flex min-w-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 transition-colors focus-within:border-blue-400 focus-within:bg-white sm:w-48">
                            <x-icon name="map-pin" class="size-4 shrink-0 text-slate-400" />
                            <select name="lokasi"
                                class="select select-ghost select-sm min-w-0 flex-1 border-0 bg-transparent px-0 text-sm text-slate-700 focus:outline-none focus:ring-0"
                                aria-label="Filter lokasi" onchange="this.form.submit()">
                                <option value="">Semua lokasi</option>
                                @foreach ($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" @selected((string) request('lokasi') === (string) $lokasi->id)>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label
                            class="flex min-w-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 transition-colors focus-within:border-blue-400 focus-within:bg-white sm:w-48">
                            <x-icon name="arrow-down-wide-narrow" class="size-4 shrink-0 text-slate-400" />
                            <select name="urut"
                                class="select select-ghost select-sm min-w-0 flex-1 border-0 bg-transparent px-0 text-sm text-slate-700 focus:outline-none focus:ring-0"
                                aria-label="Urutkan acara" onchange="this.form.submit()">
                                <option value="terdekat" @selected($urut === 'terdekat')>
                                    {{ $selesai ? 'Terbaru selesai' : 'Tanggal terdekat' }}
                                </option>
                                <option value="termurah" @selected($urut === 'termurah')>
                                    Harga termurah
                                </option>
                                <option value="terbaru" @selected($urut === 'terbaru')>
                                    Baru ditambahkan
                                </option>
                            </select>
                        </label>

                        <noscript>
                            <button type="submit" class="btn btn-primary sm:col-span-2">
                                Terapkan filter
                            </button>
                        </noscript>
                    </form>
                </div>
            </div>

            {{-- Search Results --}}
            @if ($q !== '')
                <div class="mt-7 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm text-slate-600">
                        Menampilkan <strong class="font-bold text-slate-950">{{ $events->total() }}</strong>
                        hasil untuk
                        <strong class="font-bold text-slate-950">“{{ $q }}”</strong>
                    </p>

                    <a href="{{ route('home', array_filter(['status' => $selesai ? 'selesai' : null])) }}#jelajah"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">
                        Hapus pencarian
                        <x-icon name="x" class="size-4" />
                    </a>
                </div>
            @endif

            {{-- Event Grid --}}
            @if ($events->count())
                <div class="mt-7 grid gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                    @foreach ($events as $event)
                        <x-user.event-card :event="$event" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($events->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div
                    class="mt-8 overflow-hidden rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center sm:px-10">
                    <span class="mx-auto grid size-16 place-items-center rounded-2xl bg-blue-50 text-blue-600">
                        <x-icon name="search-x" class="size-8" />
                    </span>

                    <h3 class="mt-5 text-xl font-extrabold text-slate-950">
                        Belum ada acara yang cocok
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Coba kata kunci lain atau sesuaikan filter kategori dan lokasi untuk menemukan acara yang kamu
                        cari.
                    </p>

                    <a href="{{ route('home') }}#jelajah"
                        class="mt-6 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-sm transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-icon name="rotate-ccw" class="size-4" />
                        Hapus semua filter
                    </a>
                </div>
            @endif

        </div>
    </section>
</x-layouts.app>
