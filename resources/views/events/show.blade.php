@php
    $tgl = $event->tanggal_waktu->copy()->locale('id');
    $tikets = $event->tikets->sortBy('harga')->values();

    $ticketData = $tikets
        ->map(
            fn($t) => [
                'id' => $t->id,
                'tipe' => $t->tipeTiket->nama,
                'price' => (float) $t->harga,
                'stock' => (int) $t->stok,
                'max' => min((int) $t->stok, 10),
            ],
        )
        ->values();

    $totalStok = $tikets->sum('stok');
    $bisaBeli = !$event->is_past && $totalStok > 0;
@endphp

<x-layouts.app :title="$event->judul">
    <div x-data="checkout(@js($ticketData), @js(route('orders.store')), {{ $event->id }})" class="min-h-screen bg-slate-50/70 pb-28 lg:pb-12">
        {{-- Breadcrumb --}}
        <div class="border-b border-slate-200/70 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-3.5 sm:px-6 lg:px-8">
                <nav class="flex min-w-0 items-center gap-2 text-xs font-medium sm:text-sm" aria-label="Navigasi">
                    <a href="{{ route('home') }}" class="shrink-0 text-slate-500 transition hover:text-blue-700">
                        Beranda
                    </a>

                    <x-icon name="chevron" class="size-3.5 shrink-0 -rotate-90 text-slate-300" />

                    @if ($event->kategori)
                        <a href="{{ route('home', ['kategori' => $event->kategori_id]) }}#jelajah"
                            class="shrink-0 text-slate-500 transition hover:text-blue-700">
                            {{ $event->kategori->nama }}
                        </a>

                        <x-icon name="chevron" class="size-3.5 shrink-0 -rotate-90 text-slate-300" />
                    @endif

                    <span class="truncate font-semibold text-slate-800">
                        {{ $event->judul }}
                    </span>
                </nav>
            </div>
        </div>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-9 lg:px-8 lg:py-10">
            <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-[minmax(0,1fr)_360px] xl:gap-10">

                {{-- Kolom Kiri: Informasi Event --}}
                <div class="min-w-0">

                    {{-- Poster Event --}}
                    <section
                        class="relative isolate overflow-hidden rounded-3xl border border-slate-200 bg-slate-200 shadow-sm">
                        <div class="aspect-video sm:aspect-16/8">
                            <img src="{{ $event->gambar_url }}" alt="Poster {{ $event->judul }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                                class="size-full object-cover {{ $event->is_past ? 'grayscale' : '' }}">
                        </div>

                        <div
                            class="pointer-events-none absolute inset-0 bg-linear-to-t from-slate-950/35 via-transparent to-transparent">
                        </div>

                        @if ($event->is_past)
                            <div class="absolute left-4 top-4 sm:left-6 sm:top-6">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-slate-950/75 px-3.5 py-2 text-xs font-bold text-white shadow-lg backdrop-blur-md">
                                    <span class="size-1.5 rounded-full bg-slate-300"></span>
                                    Acara telah selesai
                                </span>
                            </div>
                        @elseif ($totalStok <= 0 && $tikets->isNotEmpty())
                            <div class="absolute left-4 top-4 sm:left-6 sm:top-6">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-slate-950/75 px-3.5 py-2 text-xs font-bold text-white shadow-lg backdrop-blur-md">
                                    <span class="size-1.5 rounded-full bg-rose-400"></span>
                                    Tiket habis
                                </span>
                            </div>
                        @endif
                    </section>

                    {{-- Judul Event --}}
                    <section class="pt-6 sm:pt-8">
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($event->kategori)
                                <span
                                    class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">
                                    {{ $event->kategori->nama }}
                                </span>
                            @endif

                            @if (!$event->is_past && $totalStok > 0)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Tiket tersedia
                                </span>
                            @endif
                        </div>

                        <h1
                            class="mt-4 max-w-4xl text-3xl font-extrabold leading-tight tracking-tight text-slate-950 text-balance sm:text-4xl lg:text-[2.65rem]">
                            {{ $event->judul }}
                        </h1>

                        @if ($event->user)
                            <p class="mt-4 flex items-center gap-2 text-sm text-slate-500">
                                <span
                                    class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-200 text-xs font-extrabold uppercase text-slate-700">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($event->user->name, 0, 1)) }}
                                </span>

                                <span>
                                    Diselenggarakan oleh
                                    <span class="font-semibold text-slate-800">
                                        {{ $event->user->name }}
                                    </span>
                                </span>
                            </p>
                        @endif
                    </section>

                    {{-- Informasi Event --}}
                    <section class="mt-7 grid gap-3 sm:grid-cols-3">
                        <div
                            class="flex min-w-0 gap-3.5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-blue-50 text-blue-700">
                                <x-icon name="calendar" class="size-5" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Tanggal
                                </p>
                                <p class="mt-1.5 text-sm font-bold leading-snug text-slate-900">
                                    {{ $tgl->translatedFormat('l') }}
                                </p>
                                <p class="mt-0.5 text-xs leading-relaxed text-slate-500">
                                    {{ $tgl->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex min-w-0 gap-3.5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <span
                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-700">
                                <x-icon name="clock" class="size-5" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Waktu
                                </p>
                                <p class="mt-1.5 text-sm font-bold text-slate-900">
                                    {{ $tgl->translatedFormat('H.i') }} WIB
                                </p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Waktu mulai acara
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex min-w-0 gap-3.5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-700">
                                <x-icon name="pin" class="size-5" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Lokasi
                                </p>
                                <p class="mt-1.5 wrap-break-word text-sm font-bold leading-snug text-slate-900">
                                    {{ $event->lokasi?->nama_lokasi ?? 'Lokasi belum tersedia' }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Lokasi acara
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Deskripsi Event --}}
                    <section class="mt-8 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:mt-10 sm:p-7">
                        <div class="flex items-start gap-3">
                            <span
                                class="grid size-10 shrink-0 place-items-center rounded-xl bg-slate-100 text-slate-700">
                                <x-icon name="calendar" class="size-5" />
                            </span>

                            <div class="min-w-0">
                                <h2 class="text-xl font-extrabold tracking-tight text-slate-950">
                                    Tentang acara
                                </h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Kenali acara sebelum Anda memesan tiket.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 border-t border-slate-100 pt-5">
                            <p class="whitespace-pre-line text-sm leading-7 text-slate-600 sm:text-[15px]">
                                {{ $event->deskripsi }}
                            </p>
                        </div>
                    </section>
                </div>

                {{-- Kolom Kanan: Pilih Tiket dan Ringkasan Pesanan --}}
                <aside class="min-w-0 space-y-6 lg:sticky lg:top-24">

                    {{-- Pilih Tiket --}}
                    <section id="tiket" class="scroll-mt-28">
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex flex-wrap items-end justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-600">
                                        Pemesanan
                                    </p>
                                    <h2 class="mt-1.5 text-2xl font-extrabold tracking-tight text-slate-950">
                                        Pilih tiket
                                    </h2>
                                    <p class="mt-1.5 text-sm text-slate-500">
                                        Pilih jenis dan jumlah tiket yang Anda inginkan.
                                    </p>
                                </div>

                                @if ($bisaBeli)
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                        <x-icon name="ticket" class="size-4 text-blue-600" />
                                        {{ $tikets->where('stok', '>', 0)->count() }} jenis tersedia
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5 space-y-3">
                                @forelse ($tikets as $tiket)
                                    <article
                                        class="relative overflow-hidden rounded-2xl border bg-white transition duration-200"
                                        :class="qty[{{ $tiket->id }}] > 0 ?
                                            'border-blue-300 shadow-md shadow-blue-950/5 ring-1 ring-blue-200' :
                                            'border-slate-200 shadow-sm hover:border-slate-300 hover:shadow-md'">

                                        <div class="flex items-center gap-3 p-3 sm:gap-4 sm:p-4">
                                            {{-- Ikon Tiket --}}
                                            <div class="hidden shrink-0 sm:block">
                                                <div class="grid size-10 place-items-center rounded-xl"
                                                    :class="qty[{{ $tiket->id }}] > 0 ?
                                                        'bg-blue-600 text-white' :
                                                        'bg-slate-100 text-slate-500'">
                                                    <x-icon name="ticket" class="size-5" />
                                                </div>
                                            </div>

                                            {{-- Detail Tiket --}}
                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                                                        {{ $tiket->tipeTiket->nama }}
                                                    </h3>

                                                    @if ($tiket->stok <= 0)
                                                        <span
                                                            class="rounded-full bg-rose-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-rose-600">
                                                            Habis
                                                        </span>
                                                    @elseif ($tiket->stok <= 20)
                                                        <span
                                                            class="rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700">
                                                            Stok terbatas
                                                        </span>
                                                    @endif
                                                </div>

                                                <p class="mt-1.5 text-lg font-extrabold tracking-tight text-blue-700">
                                                    {{ (float) $tiket->harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($tiket->harga, 0, ',', '.') }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-500">
                                                    @if ($tiket->stok <= 0)
                                                        Tiket tidak tersedia
                                                    @elseif ($tiket->stok <= 20)
                                                        Tersisa {{ $tiket->stok }} tiket
                                                    @else
                                                        Tiket tersedia
                                                    @endif
                                                </p>
                                            </div>

                                            {{-- Kontrol Jumlah --}}
                                            @if ($bisaBeli && $tiket->stok > 0)
                                                <div class="flex shrink-0 items-center gap-1.5 sm:gap-2"
                                                    role="group"
                                                    aria-label="Jumlah tiket {{ $tiket->tipeTiket->nama }}">

                                                    <button type="button"
                                                        class="grid size-9 place-items-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 disabled:cursor-not-allowed disabled:opacity-40"
                                                        @click="step(tickets.find(t => t.id === {{ $tiket->id }}), -1)"
                                                        :disabled="qty[{{ $tiket->id }}] === 0"
                                                        aria-label="Kurangi satu tiket">
                                                        <x-icon name="minus" class="size-4" />
                                                    </button>

                                                    <output
                                                        class="w-5 text-center text-base font-extrabold tabular-nums text-slate-900"
                                                        x-text="qty[{{ $tiket->id }}]"
                                                        aria-live="polite">0</output>

                                                    <button type="button"
                                                        class="grid size-9 place-items-center rounded-xl bg-blue-600 text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-40"
                                                        @click="step(tickets.find(t => t.id === {{ $tiket->id }}), 1)"
                                                        :disabled="qty[{{ $tiket->id }}] >= {{ min($tiket->stok, 10) }}"
                                                        aria-label="Tambah satu tiket">
                                                        <x-icon name="plus" class="size-4" />
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </article>
                                @empty
                                    <div
                                        class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-10 text-center">
                                        <span
                                            class="mx-auto grid size-14 place-items-center rounded-2xl bg-slate-100 text-slate-400">
                                            <x-icon name="ticket" class="size-6" />
                                        </span>
                                        <h3 class="mt-4 font-bold text-slate-900">
                                            Tiket belum tersedia
                                        </h3>
                                        <p class="mx-auto mt-1.5 max-w-sm text-sm leading-relaxed text-slate-500">
                                            Penyelenggara belum menambahkan tiket untuk acara ini.
                                            Silakan periksa kembali nanti.
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            @if ($bisaBeli)
                                <p class="mt-4 flex items-start gap-2 text-xs leading-relaxed text-slate-500">
                                    <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-emerald-600" />
                                    Maksimal 10 tiket per jenis dalam satu pesanan. Jumlah yang dapat
                                    dipilih mengikuti stok yang tersedia.
                                </p>
                            @endif
                        </div>
                    </section>

                    {{-- Ringkasan Pesanan --}}
                    <section
                        class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg shadow-slate-950/4">

                        <div class="bg-linear-to-br from-slate-950 to-slate-800 px-5 py-5 text-white sm:px-6">
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-300">
                                BengTix Checkout
                            </p>
                            <h2 class="mt-1.5 text-xl font-extrabold tracking-tight">
                                Ringkasan pesanan
                            </h2>
                            <p class="mt-1 text-xs text-slate-300">
                                Periksa pilihan tiket Anda.
                            </p>
                        </div>

                        <div class="p-5">
                            <div class="rounded-2xl bg-slate-50 p-3.5">
                                <p class="line-clamp-2 text-sm font-bold leading-snug text-slate-900">
                                    {{ $event->judul }}
                                </p>
                                <p class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                                    <x-icon name="calendar" class="size-3.5 shrink-0" />
                                    {{ $tgl->translatedFormat('d F Y') }}
                                </p>
                            </div>

                            <div class="mt-5">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                                        Tiket pilihan
                                    </h3>
                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">
                                        <span x-text="count"></span> tiket
                                    </span>
                                </div>

                                <ul class="mt-4 min-h-12 space-y-3 text-sm">
                                    <template x-for="l in lines" :key="l.id">
                                        <li class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="font-semibold leading-snug text-slate-800" x-text="l.tipe">
                                                </p>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    <span x-text="l.qty"></span> × tiket
                                                </p>
                                            </div>
                                            <span class="shrink-0 font-bold tabular-nums text-slate-800"
                                                x-text="rupiah(l.subtotal)"></span>
                                        </li>
                                    </template>

                                    <li x-show="count === 0"
                                        class="rounded-xl border border-dashed border-slate-200 px-3 py-4 text-center text-xs leading-relaxed text-slate-500">
                                        Belum ada tiket dipilih. Tentukan jumlah tiket terlebih dahulu.
                                    </li>
                                </ul>
                            </div>

                            <div class="my-5 border-t border-dashed border-slate-200"></div>

                            <div class="flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-500">
                                        Total pembayaran
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        Sesuai tiket yang dipilih
                                    </p>
                                </div>
                                <span class="text-right text-2xl font-extrabold tracking-tight text-slate-950"
                                    x-text="rupiah(total)">Rp 0</span>
                            </div>

                            @include('events.partials.cta', [
                                'bisaBeli' => $bisaBeli,
                                'event' => $event,
                            ])

                            <p class="mt-3 text-center text-[11px] leading-relaxed text-slate-400">
                                Pastikan jenis dan jumlah tiket sudah benar sebelum melanjutkan.
                            </p>
                        </div>
                    </section>
                </aside>
            </div>
        </main>

        {{-- Mobile Bottom Checkout Bar --}}
        <div
            class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-200 bg-white/95 p-3 shadow-[0_-8px_30px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-4 lg:hidden">
            <div class="mx-auto flex max-w-xl items-center gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-slate-500">
                        <span x-text="count"></span> tiket dipilih
                    </p>
                    <p class="mt-0.5 truncate text-xl font-extrabold tracking-tight text-slate-950"
                        x-text="rupiah(total)">Rp 0</p>
                </div>

                <div class="w-[52%] max-w-64">
                    @include('events.partials.cta', [
                        'bisaBeli' => $bisaBeli,
                        'event' => $event,
                        'compact' => true,
                    ])
                </div>
            </div>
        </div>

        {{-- Dialog Konfirmasi Pesanan --}}
        <dialog x-ref="dlg" x-effect="open ? $refs.dlg.showModal() : $refs.dlg.close()" @close="open = false"
            class="modal modal-bottom sm:modal-middle">

            <div
                class="modal-box max-h-[90vh] rounded-t-3xl border border-slate-200 bg-white p-0 shadow-2xl sm:max-w-lg sm:rounded-3xl">

                <div class="bg-linear-to-br from-slate-950 to-slate-800 px-5 py-6 text-white sm:px-7">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-300">
                        Langkah terakhir
                    </p>
                    <h3 class="mt-1.5 text-2xl font-extrabold tracking-tight">
                        Konfirmasi pesanan
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        Periksa kembali detail tiket sebelum pesanan diproses.
                    </p>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Acara
                        </p>
                        <p class="mt-1.5 font-bold leading-snug text-slate-900">
                            {{ $event->judul }}
                        </p>
                        <p class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                            <x-icon name="calendar" class="size-4 shrink-0" />
                            {{ $tgl->translatedFormat('l, d F Y') }}
                            · {{ $tgl->translatedFormat('H.i') }} WIB
                        </p>
                    </div>

                    <h4 class="mt-5 text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                        Detail tiket
                    </h4>

                    <ul class="mt-3 space-y-3 text-sm">
                        <template x-for="l in lines" :key="l.id">
                            <li class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800" x-text="l.tipe"></p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        <span x-text="l.qty"></span> × tiket
                                    </p>
                                </div>
                                <span class="shrink-0 font-bold tabular-nums text-slate-900"
                                    x-text="rupiah(l.subtotal)"></span>
                            </li>
                        </template>
                    </ul>

                    <div class="my-5 border-t border-dashed border-slate-200"></div>

                    <div class="flex items-center justify-between gap-3">
                        <span class="font-semibold text-slate-600">Total pembayaran</span>
                        <span class="text-2xl font-extrabold tracking-tight text-slate-950" x-text="rupiah(total)">Rp
                            0</span>
                    </div>

                    <div x-show="error" x-cloak
                        class="mt-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700"
                        role="alert">
                        <span x-text="error"></span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button type="button"
                            class="inline-flex h-12 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-bold text-slate-700 transition hover:bg-slate-50 disabled:opacity-50"
                            @click="open = false" :disabled="loading">
                            Batal
                        </button>

                        <button type="button"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            @click="submit()" :disabled="loading || count === 0">
                            <span x-show="loading" class="loading loading-spinner loading-sm"></span>
                            <span x-text="loading ? 'Memproses...' : 'Konfirmasi'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <form method="dialog" class="modal-backdrop">
                <button aria-label="Tutup">tutup</button>
            </form>
        </dialog>
    </div>
</x-layouts.app>
