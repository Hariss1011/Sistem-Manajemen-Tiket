<x-layouts.app title="Pesanan saya">
    <section class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 sm:py-12">

            {{-- Header halaman --}}
            <div class="flex flex-col gap-5 border-b border-slate-200 pb-7 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
                        <x-icon name="chevron" class="size-4 rotate-180" />
                        Kembali ke beranda
                    </a>

                    <div class="mt-5 flex items-center gap-3">
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                            <x-icon name="ticket" class="size-6" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                                Pesanan saya
                            </h1>
                            <p class="mt-1 text-sm text-slate-500 sm:text-base">
                                Kelola dan lihat kembali tiket acara yang kamu pesan.
                            </p>
                        </div>
                    </div>
                </div>

                @if ($orders->total() > 0)
                    <div
                        class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm">
                        <x-icon name="ticket" class="size-4 text-blue-600" />
                        {{ $orders->total() }} pesanan
                    </div>
                @endif
            </div>

            {{-- Daftar pesanan --}}
            <div class="mt-7 space-y-4">
                @forelse ($orders as $order)
                    @php
                        $event = $order->event;
                        $tgl = $event?->tanggal_waktu?->copy()->locale('id');
                        $total = (float) $order->total_harga;
                    @endphp

                    <a href="{{ route('orders.show', $order) }}"
                        class="group block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-lg hover:shadow-slate-200/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">

                        <div class="flex flex-col sm:flex-row">
                            {{-- Poster acara --}}
                            <div
                                class="relative h-44 shrink-0 overflow-hidden bg-slate-100 sm:h-auto sm:min-h-44 sm:w-52">
                                <img src="{{ $event?->gambar_url }}" alt="{{ $event?->judul ?? 'Poster acara' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                                @if ($event)
                                    <span
                                        class="absolute left-3 top-3 rounded-full border border-white/70 bg-white/95 px-3 py-1 text-xs font-bold text-slate-700 shadow-sm">
                                        {{ $event->is_past ? 'Acara selesai' : 'Acara mendatang' }}
                                    </span>
                                @endif
                            </div>

                            {{-- Informasi pesanan --}}
                            <div class="flex min-w-0 flex-1 flex-col justify-between gap-5 p-4 sm:p-5">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">
                                            Pesanan #{{ $order->id }}
                                        </span>
                                        <span class="text-xs text-slate-400">
                                            {{ $order->order_date->locale('id')->translatedFormat('d M Y, H.i') }} WIB
                                        </span>
                                    </div>

                                    <h2
                                        class="mt-3 line-clamp-2 text-lg font-extrabold leading-snug text-slate-900 transition group-hover:text-blue-700 sm:text-xl">
                                        {{ $event?->judul ?? 'Event dihapus' }}
                                    </h2>

                                    @if ($tgl)
                                        <div class="mt-3 flex items-start gap-2 text-sm text-slate-500">
                                            <x-icon name="calendar" class="mt-0.5 size-4 shrink-0 text-blue-600" />
                                            <span>{{ $tgl->translatedFormat('l, d F Y · H.i') }} WIB</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-end justify-between gap-3 border-t border-slate-100 pt-4">
                                    <div>
                                        <p class="text-xs font-medium text-slate-400">Total pembayaran</p>
                                        <p class="mt-1 text-lg font-extrabold tracking-tight text-slate-900 sm:text-xl">
                                            {{ $total === 0.0 ? 'Gratis' : 'Rp ' . number_format($total, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <span
                                        class="inline-flex shrink-0 items-center gap-1.5 text-sm font-bold text-blue-600 transition group-hover:gap-2.5">
                                        Detail
                                        <x-icon name="chevron" class="size-4" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Empty state --}}
                    <div
                        class="overflow-hidden rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center sm:px-10 sm:py-20">
                        <div
                            class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <x-icon name="ticket" class="size-8" />
                        </div>

                        <h2 class="mt-5 text-xl font-extrabold text-slate-900 sm:text-2xl">
                            Belum ada pesanan
                        </h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 sm:text-base">
                            Acara yang kamu pesan akan muncul di sini. Yuk, temukan acara menarik dan buat pengalaman
                            baru!
                        </p>

                        <a href="{{ route('home') }}#jelajah"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <x-icon name="compass" class="size-4" />
                            Jelajahi acara
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-3 sm:p-4">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </section>
</x-layouts.app>
