<x-layouts.app>
    {{-- Hero --}}
    <section class="border-b border-base-300">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-12 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:py-20">
            <div>
                <h1 class="max-w-xl text-4xl font-extrabold leading-[1.1] tracking-tight text-balance sm:text-5xl">
                    Temukan acara berikutnya, amankan tiketmu.
                </h1>
                <p class="mt-5 max-w-md text-lg leading-relaxed text-base-content/70">
                    Konser, seminar, dan workshop di satu tempat. Pilih tiket, pesan, selesai.
                </p>

                <form method="GET" action="{{ route('home') }}#jelajah" role="search" class="mt-8 flex max-w-xl gap-2">
                    <label class="input input-lg flex-1 items-center gap-3 bg-base-100">
                        <x-icon name="search" class="size-5 text-base-content/50" />
                        <input type="search" name="q" value="{{ $q }}" class="grow"
                            placeholder="Cari nama acara atau lokasi" aria-label="Cari acara">
                    </label>
                    <button class="btn btn-primary btn-lg">Cari acara</button>
                </form>

                <p class="mt-4 text-sm text-base-content/60">{{ $totalUpcoming }} acara akan datang</p>
            </div>

            @if ($featured)
                @php
                    $fd = $featured->tanggal_waktu->copy()->locale('id');
                    $fmin = $featured->tikets_min_harga;
                @endphp
                <a href="{{ route('events.show', $featured) }}"
                    class="ticket-wrap group block rounded-box lg:ml-auto lg:w-full lg:max-w-md"
                    aria-label="Acara terdekat: {{ $featured->judul }}">
                    <article class="ticket bg-primary text-primary-content" style="--stub: 5.5rem">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img src="{{ $featured->gambar_url }}" alt=""
                                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                                class="size-full object-cover">
                            <span
                                class="absolute left-4 top-4 rounded-full bg-accent px-3 py-1 text-xs font-bold text-accent-content">Acara
                                terdekat</span>
                        </div>
                        <div class="space-y-3 p-6">
                            <h2 class="text-2xl font-extrabold leading-tight text-balance">{{ $featured->judul }}</h2>
                            <p class="flex items-center gap-2 text-sm text-primary-content/80">
                                <x-icon name="calendar" class="size-4" />
                                {{ $fd->translatedFormat('l, d F Y · H.i') }} WIB
                            </p>
                            <p class="flex items-center gap-2 text-sm text-primary-content/80">
                                <x-icon name="pin" class="size-4" /> {{ $featured->lokasi?->nama_lokasi }}
                            </p>
                        </div>
                        <div class="ticket-stub flex items-center justify-between px-6"
                            style="background-image: linear-gradient(to right, rgb(255 255 255 / .35) 55%, transparent 0)">
                            <div class="leading-tight">
                                @if ($fmin > 0)
                                    <p class="text-xs text-primary-content/70">Mulai dari</p>
                                @endif
                                <p class="text-xl font-extrabold">
                                    {{ is_null($fmin) ? 'Tiket belum dibuka' : ((float) $fmin === 0.0 ? 'Gratis' : 'Rp ' . number_format($fmin, 0, ',', '.')) }}
                                </p>
                            </div>
                            <span class="btn btn-secondary btn-sm">Lihat tiket</span>
                        </div>
                    </article>
                </a>
            @endif
        </div>
    </section>

    {{-- Jelajah --}}
    <section id="jelajah" class="mx-auto max-w-7xl scroll-mt-20 px-4 py-12 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="text-2xl font-extrabold tracking-tight">
                {{ $selesai ? 'Acara yang sudah selesai' : 'Acara akan datang' }}</h2>

            <div class="tabs tabs-box bg-base-100" role="tablist">
                <a role="tab"
                    href="{{ route('home', array_filter(['q' => $q, 'kategori' => request('kategori'), 'lokasi' => request('lokasi'), 'urut' => request('urut')])) }}#jelajah"
                    class="tab {{ !$selesai ? 'tab-active' : '' }}">Akan datang</a>
                <a role="tab"
                    href="{{ route('home', array_filter(['status' => 'selesai', 'q' => $q, 'kategori' => request('kategori'), 'lokasi' => request('lokasi'), 'urut' => request('urut')])) }}#jelajah"
                    class="tab {{ $selesai ? 'tab-active' : '' }}">Sudah selesai</a>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <nav class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0" aria-label="Kategori">
                @php $base = array_filter(['q' => $q, 'status' => $selesai ? 'selesai' : null, 'lokasi' => request('lokasi'), 'urut' => request('urut')]); @endphp
                <x-user.category-pill label="Semua" :href="route('home', $base) . '#jelajah'" :active="!request('kategori')" />
                @foreach ($categories as $kategori)
                    <x-user.category-pill :label="$kategori->nama" :href="route('home', $base + ['kategori' => $kategori->id]) . '#jelajah'" :active="(string) request('kategori') === (string) $kategori->id" />
                @endforeach
            </nav>

            <form method="GET" action="{{ route('home') }}#jelajah" class="flex flex-wrap gap-2">
                @foreach (array_filter(['q' => $q, 'status' => $selesai ? 'selesai' : null, 'kategori' => request('kategori')]) as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach

                <select name="lokasi" class="select select-sm w-44 bg-base-100" aria-label="Filter lokasi"
                    onchange="this.form.submit()">
                    <option value="">Semua lokasi</option>
                    @foreach ($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}" @selected((string) request('lokasi') === (string) $lokasi->id)>
                            {{ $lokasi->nama_lokasi }}</option>
                    @endforeach
                </select>

                <select name="urut" class="select select-sm w-44 bg-base-100" aria-label="Urutkan"
                    onchange="this.form.submit()">
                    <option value="terdekat" @selected($urut === 'terdekat')>
                        {{ $selesai ? 'Terbaru selesai' : 'Tanggal terdekat' }}</option>
                    <option value="termurah" @selected($urut === 'termurah')>Harga termurah</option>
                    <option value="terbaru" @selected($urut === 'terbaru')>Baru ditambahkan</option>
                </select>
                <noscript><button class="btn btn-sm">Terapkan</button></noscript>
            </form>
        </div>

        @if ($q !== '')
            <p class="mt-6 text-sm text-base-content/70">
                {{ $events->total() }} hasil untuk <strong>“{{ $q }}”</strong>
            </p>
        @endif

        @if ($events->count())
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($events as $event)
                    <x-user.event-card :event="$event" />
                @endforeach
            </div>

            <div class="mt-10">{{ $events->links() }}</div>
        @else
            <div class="mt-8 rounded-box border border-dashed border-base-300 bg-base-100 px-6 py-16 text-center">
                <p class="text-lg font-bold">Belum ada acara yang cocok.</p>
                <p class="mt-1 text-base-content/70">Coba kata kunci lain atau hapus filter yang aktif.</p>
                <a href="{{ route('home') }}#jelajah" class="btn btn-primary btn-sm mt-5">Hapus semua filter</a>
            </div>
        @endif
    </section>
</x-layouts.app>
