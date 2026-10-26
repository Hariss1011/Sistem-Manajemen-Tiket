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
    <div x-data="checkout(@js($ticketData), @js(route('orders.store')), {{ $event->id }})" class="pb-28 lg:pb-0">
        <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
            <nav class="breadcrumbs text-sm" aria-label="Navigasi">
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    @if ($event->kategori)
                        <li><a
                                href="{{ route('home', ['kategori' => $event->kategori_id]) }}#jelajah">{{ $event->kategori->nama }}</a>
                        </li>
                    @endif
                    <li class="truncate">{{ $event->judul }}</li>
                </ul>
            </nav>

            <div class="mt-4 grid gap-8 lg:grid-cols-[1fr_22rem]">
                <div>
                    <div class="relative aspect-[16/8] overflow-hidden rounded-box bg-base-300">
                        <img src="{{ $event->gambar_url }}" alt="Poster {{ $event->judul }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                            class="size-full object-cover {{ $event->is_past ? 'grayscale' : '' }}">
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-2">
                        @if ($event->kategori)
                            <span class="badge badge-primary">{{ $event->kategori->nama }}</span>
                        @endif
                        @if ($event->is_past)
                            <span class="badge badge-neutral">Acara selesai</span>
                        @elseif ($totalStok <= 0 && $tikets->isNotEmpty())
                            <span class="badge badge-neutral">Tiket habis</span>
                        @endif
                    </div>

                    <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight text-balance sm:text-4xl">
                        {{ $event->judul }}</h1>

                    <dl class="mt-6 grid gap-4 rounded-box border border-base-300 bg-base-100 p-5 sm:grid-cols-3">
                        <div class="flex gap-3">
                            <x-icon name="calendar" class="mt-0.5 size-5 shrink-0 text-secondary" />
                            <div>
                                <dt class="text-xs text-base-content/60">Tanggal</dt>
                                <dd class="font-semibold">{{ $tgl->translatedFormat('l, d F Y') }}</dd>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <x-icon name="clock" class="mt-0.5 size-5 shrink-0 text-secondary" />
                            <div>
                                <dt class="text-xs text-base-content/60">Waktu</dt>
                                <dd class="font-semibold">{{ $tgl->translatedFormat('H.i') }} WIB</dd>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <x-icon name="pin" class="mt-0.5 size-5 shrink-0 text-secondary" />
                            <div>
                                <dt class="text-xs text-base-content/60">Lokasi</dt>
                                <dd class="font-semibold">{{ $event->lokasi?->nama_lokasi }}</dd>
                            </div>
                        </div>
                    </dl>

                    <h2 class="mt-10 text-xl font-extrabold">Tentang acara</h2>
                    <p class="mt-3 max-w-prose whitespace-pre-line leading-relaxed text-base-content/80">
                        {{ $event->deskripsi }}</p>
                    @if ($event->user)
                        <p class="mt-4 text-sm text-base-content/60">Diselenggarakan oleh {{ $event->user->name }}</p>
                    @endif

                    <h2 id="tiket" class="mt-10 scroll-mt-24 text-xl font-extrabold">Pilih tiket</h2>

                    <div class="mt-4 space-y-3">
                        @forelse ($tikets as $tiket)
                            <div class="flex items-center justify-between gap-4 rounded-box border bg-base-100 p-4"
                                :class="qty[{{ $tiket->id }}] > 0 ? 'border-primary ring-1 ring-primary' : 'border-base-300'">
                                <div class="min-w-0">
                                    <h3 class="font-bold">{{ $tiket->tipeTiket->nama }}</h3>
                                    <p class="mt-0.5 text-lg font-extrabold text-primary">
                                        {{ (float) $tiket->harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($tiket->harga, 0, ',', '.') }}
                                    </p>
                                    <p
                                        class="mt-0.5 text-xs {{ $tiket->stok <= 0 ? 'font-semibold text-error' : ($tiket->stok <= 20 ? 'font-semibold text-warning' : 'text-base-content/60') }}">
                                        {{ $tiket->stok <= 0 ? 'Habis' : ($tiket->stok <= 20 ? 'Tersisa ' . $tiket->stok : 'Tersedia') }}
                                    </p>
                                </div>

                                @if ($bisaBeli && $tiket->stok > 0)
                                    <div class="flex items-center gap-1" role="group"
                                        aria-label="Jumlah tiket {{ $tiket->tipeTiket->nama }}">
                                        <button type="button" class="btn btn-circle btn-sm btn-outline"
                                            @click="step(tickets.find(t => t.id === {{ $tiket->id }}), -1)"
                                            :disabled="qty[{{ $tiket->id }}] === 0" aria-label="Kurangi satu tiket">
                                            <x-icon name="minus" />
                                        </button>
                                        <output class="w-8 text-center text-lg font-bold tabular-nums"
                                            x-text="qty[{{ $tiket->id }}]" aria-live="polite">0</output>
                                        <button type="button" class="btn btn-circle btn-sm btn-primary"
                                            @click="step(tickets.find(t => t.id === {{ $tiket->id }}), 1)"
                                            :disabled="qty[{{ $tiket->id }}] >= {{ min($tiket->stok, 10) }}"
                                            aria-label="Tambah satu tiket">
                                            <x-icon name="plus" />
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-box border border-dashed border-base-300 bg-base-100 p-6 text-center">
                                <p class="font-bold">Tiket belum dibuka.</p>
                                <p class="text-sm text-base-content/70">Cek lagi nanti, penyelenggara belum menambahkan
                                    tiket.</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($bisaBeli)
                        <p class="mt-3 text-xs text-base-content/60">Maksimal 10 tiket per jenis dalam satu pesanan.</p>
                    @endif
                </div>

                {{-- Ringkasan (desktop) --}}
                <aside class="hidden lg:block">
                    <div class="sticky top-24 rounded-box border border-base-300 bg-base-100 p-5">
                        <h2 class="text-lg font-extrabold">Ringkasan pesanan</h2>

                        <ul class="mt-4 min-h-12 space-y-2 text-sm">
                            <template x-for="l in lines" :key="l.id">
                                <li class="flex justify-between gap-3">
                                    <span><span x-text="l.tipe"></span> × <span x-text="l.qty"></span></span>
                                    <span class="font-semibold" x-text="rupiah(l.subtotal)"></span>
                                </li>
                            </template>
                            <li x-show="count === 0" class="text-base-content/60">Pilih jumlah tiket di sebelah kiri.
                            </li>
                        </ul>

                        <div class="my-4 border-t border-dashed border-base-300"></div>

                        <div class="flex items-center justify-between">
                            <span class="text-base-content/70">Total</span>
                            <span class="text-2xl font-extrabold" x-text="rupiah(total)">Rp 0</span>
                        </div>

                        @include('events.partials.cta', ['bisaBeli' => $bisaBeli, 'event' => $event])
                    </div>
                </aside>
            </div>
        </section>

        {{-- Bar bawah (mobile) --}}
        <div class="fixed inset-x-0 bottom-0 z-30 border-t border-base-300 bg-base-100 p-4 lg:hidden">
            <div class="mx-auto flex max-w-xl items-center gap-4">
                <div class="leading-tight">
                    <p class="text-xs text-base-content/60"><span x-text="count"></span> tiket</p>
                    <p class="text-lg font-extrabold" x-text="rupiah(total)">Rp 0</p>
                </div>
                <div class="flex-1">
                    @include('events.partials.cta', [
                        'bisaBeli' => $bisaBeli,
                        'event' => $event,
                        'compact' => true,
                    ])
                </div>
            </div>
        </div>

        {{-- Konfirmasi --}}
        <dialog x-ref="dlg" x-effect="open ? $refs.dlg.showModal() : $refs.dlg.close()" @close="open = false"
            class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <h3 class="text-lg font-extrabold">Konfirmasi pesanan</h3>
                <p class="mt-1 text-sm text-base-content/70">{{ $event->judul }}</p>

                <ul class="mt-5 space-y-2 text-sm">
                    <template x-for="l in lines" :key="l.id">
                        <li class="flex justify-between gap-3">
                            <span><span x-text="l.tipe"></span> × <span x-text="l.qty"></span></span>
                            <span class="font-semibold" x-text="rupiah(l.subtotal)"></span>
                        </li>
                    </template>
                </ul>

                <div class="my-4 border-t border-dashed border-base-300"></div>
                <div class="flex items-center justify-between">
                    <span class="font-semibold">Total</span>
                    <span class="text-xl font-extrabold" x-text="rupiah(total)"></span>
                </div>

                <div x-show="error" x-cloak class="alert alert-error mt-4 text-sm" role="alert">
                    <span x-text="error"></span>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" @click="open = false"
                        :disabled="loading">Batal</button>
                    <button type="button" class="btn btn-primary" @click="submit()"
                        :disabled="loading || count === 0">
                        <span x-show="loading" class="loading loading-spinner loading-sm"></span>
                        <span x-text="loading ? 'Memproses' : 'Konfirmasi pesanan'"></span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop"><button aria-label="Tutup">tutup</button></form>
        </dialog>
    </div>
</x-layouts.app>
