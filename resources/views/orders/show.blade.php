@php
    $event = $order->event;
    $tgl = $event?->tanggal_waktu?->copy()->locale('id');
    $jumlah = $order->detailOrders->sum('jumlah');
    $total = (float) $order->total_harga;
@endphp

<x-layouts.app :title="'Pesanan #' . $order->id">
    <section class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-12">

            {{-- Navigasi dan judul --}}
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
                <x-icon name="chevron" class="size-4 rotate-180" />
                Semua pesanan
            </a>

            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-blue-600">
                        Detail transaksi
                    </p>
                    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Pesanan #{{ $order->id }}
                    </h1>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Dibuat pada {{ $order->order_date->locale('id')->translatedFormat('l, d F Y · H.i') }} WIB
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3.5 py-2 text-sm font-bold text-emerald-700">
                    <x-icon name="check-circle" class="size-4" />
                    Pesanan berhasil
                </span>
            </div>

            {{-- Tiket digital --}}
            <article class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-900 px-5 py-4 text-white sm:px-7">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex size-10 items-center justify-center rounded-xl bg-blue-500/15 text-blue-300">
                                <x-icon name="ticket" class="size-5" />
                            </div>
                            <div>
                                <p class="text-sm font-extrabold">BengTix</p>
                                <p class="mt-0.5 text-xs text-slate-400">Ringkasan tiket acara</p>
                            </div>
                        </div>

                        <p class="text-right text-xs font-semibold text-slate-400">
                            ID PESANAN
                            <span class="mt-1 block text-sm text-white">#{{ $order->id }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
                    {{-- Poster acara --}}
                    <div class="min-h-52 overflow-hidden bg-slate-100 sm:min-h-80">
                        <img src="{{ $event?->gambar_url }}" alt="{{ $event?->judul ?? 'Poster acara' }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                            class="h-full max-h-80 w-full object-cover sm:max-h-none">
                    </div>

                    {{-- Informasi acara --}}
                    <div class="flex flex-col justify-center p-5 sm:p-7">
                        @if ($event)
                            <span
                                class="inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-bold {{ $event->is_past ? 'bg-slate-100 text-slate-600' : 'bg-blue-50 text-blue-700' }}">
                                {{ $event->is_past ? 'Acara telah selesai' : 'Acara mendatang' }}
                            </span>
                        @endif

                        <h2 class="mt-4 text-2xl font-extrabold leading-snug tracking-tight text-slate-900 sm:text-3xl">
                            {{ $event?->judul ?? 'Event dihapus' }}
                        </h2>

                        <div class="mt-5 space-y-4">
                            @if ($tgl)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <x-icon name="calendar" class="size-4" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-400">Tanggal dan waktu</p>
                                        <p class="mt-1 text-sm font-semibold leading-6 text-slate-700">
                                            {{ $tgl->translatedFormat('l, d F Y') }}
                                            <span class="block">{{ $tgl->format('H.i') }} WIB</span>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($event?->lokasi)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <x-icon name="pin" class="size-4" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-400">Lokasi acara</p>
                                        <p class="mt-1 text-sm font-semibold leading-6 text-slate-700">
                                            {{ $event->lokasi->nama_lokasi }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($event && !$event->trashed())
                            <a href="{{ route('events.show', $event) }}"
                                class="mt-6 inline-flex w-fit items-center gap-2 text-sm font-bold text-blue-600 transition hover:text-blue-800">
                                Lihat halaman acara
                                <x-icon name="chevron" class="size-4" />
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Ringkasan total --}}
                <div class="border-t border-dashed border-slate-300 bg-slate-50 px-5 py-5 sm:px-7">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Tiket dipesan
                            </p>
                            <p class="mt-1 text-lg font-extrabold text-slate-900">
                                {{ $jumlah }} tiket
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Total pesanan
                            </p>
                            <p class="mt-1 text-2xl font-extrabold tracking-tight text-blue-700 sm:text-3xl">
                                {{ $total === 0.0 ? 'Gratis' : 'Rp ' . number_format($total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Rincian tiket --}}
            <div class="mt-9">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-900">
                            Rincian tiket
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Periksa jenis, jumlah, dan harga tiket dalam pesanan ini.
                        </p>
                    </div>
                    <span class="mt-2 text-sm font-semibold text-slate-500 sm:mt-0">
                        {{ $order->detailOrders->count() }} jenis tiket
                    </span>
                </div>

                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[580px] border-collapse text-sm">
                            <thead>
                                <tr
                                    class="bg-slate-100 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <th class="px-5 py-4">Jenis tiket</th>
                                    <th class="px-5 py-4 text-right">Harga satuan</th>
                                    <th class="px-5 py-4 text-center">Jumlah</th>
                                    <th class="px-5 py-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($order->detailOrders as $d)
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-5 py-4">
                                            <p class="font-bold text-slate-800">
                                                {{ $d->tiket->tipeTiket->nama }}
                                            </p>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-slate-600">
                                            {{ (float) $d->tiket->harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($d->tiket->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span
                                                class="inline-flex min-w-9 items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1.5 font-bold text-slate-700">
                                                {{ $d->jumlah }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right font-bold text-slate-900">
                                            {{ (float) $d->subtotal_harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($d->subtotal_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-slate-200 bg-slate-50">
                                    <td colspan="3" class="px-5 py-4 text-right font-bold text-slate-600">
                                        Total pesanan
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-5 py-4 text-right text-base font-extrabold text-blue-700">
                                        {{ $total === 0.0 ? 'Gratis' : 'Rp ' . number_format($total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <p class="border-t border-slate-100 px-5 py-3 text-xs leading-5 text-slate-400">
                        Total pada rincian ini mengikuti data pesanan yang tersimpan.
                    </p>
                </div>
            </div>

            {{-- Navigasi bawah --}}
            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-400 hover:bg-slate-100">
                    <x-icon name="chevron" class="size-4 rotate-180" />
                    Kembali ke pesanan
                </a>

                <a href="{{ route('home') }}#jelajah"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700">
                    <x-icon name="compass" class="size-4" />
                    Jelajahi acara lainnya
                </a>
            </div>

        </div>
    </section>
</x-layouts.app>
