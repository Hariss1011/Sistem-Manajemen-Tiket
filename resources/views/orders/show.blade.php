@php
    $event = $order->event;
    $tgl = $event?->tanggal_waktu?->copy()->locale('id');
    $jumlah = $order->detailOrders->sum('jumlah');
@endphp

<x-layouts.app :title="'Pesanan #' . $order->id">
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <a href="{{ route('orders.index') }}" class="link link-hover inline-flex items-center gap-1 text-sm">
            <x-icon name="chevron" class="size-3 rotate-180" /> Semua pesanan
        </a>

        <h1 class="mt-3 text-3xl font-extrabold tracking-tight">Pesanan #{{ $order->id }}</h1>
        <p class="mt-1 text-base-content/70">Dibuat
            {{ $order->order_date->locale('id')->translatedFormat('l, d F Y · H.i') }} WIB</p>

        <div class="ticket-wrap mt-8">
            <article class="ticket" style="--stub: 5.5rem">
                <div class="grid sm:grid-cols-[14rem_1fr]">
                    <img src="{{ $event?->gambar_url }}" alt=""
                        onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                        class="h-40 w-full object-cover sm:h-full">
                    <div class="space-y-2 p-5">
                        <h2 class="text-xl font-extrabold leading-snug text-balance">
                            {{ $event?->judul ?? 'Event dihapus' }}</h2>
                        @if ($tgl)
                            <p class="flex items-center gap-2 text-sm text-base-content/70">
                                <x-icon name="calendar" class="size-4" /> {{ $tgl->translatedFormat('l, d F Y · H.i') }}
                                WIB
                            </p>
                        @endif
                        @if ($event?->lokasi)
                            <p class="flex items-center gap-2 text-sm text-base-content/70">
                                <x-icon name="pin" class="size-4" /> {{ $event->lokasi->nama_lokasi }}
                            </p>
                        @endif
                        @if ($event && !$event->trashed())
                            <a href="{{ route('events.show', $event) }}"
                                class="link link-primary mt-2 inline-block text-sm font-semibold">Lihat halaman
                                acara</a>
                        @endif
                    </div>
                </div>

                <div class="ticket-stub flex items-center justify-between px-5">
                    <div class="leading-tight">
                        <p class="text-xs text-base-content/60">{{ $jumlah }} tiket</p>
                        <p class="text-2xl font-extrabold text-primary">
                            {{ (float) $order->total_harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($order->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </article>
        </div>

        <h2 class="mt-10 text-lg font-extrabold">Rincian tiket</h2>
        <div class="mt-3 overflow-x-auto rounded-box border border-base-300 bg-base-100">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jenis tiket</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->detailOrders as $d)
                        <tr>
                            <td class="font-semibold">{{ $d->tiket->tipeTiket->nama }}</td>
                            <td class="text-right">
                                {{ (float) $d->tiket->harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($d->tiket->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-right">{{ $d->jumlah }}</td>
                            <td class="text-right font-semibold">
                                {{ (float) $d->subtotal_harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($d->subtotal_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.app>
