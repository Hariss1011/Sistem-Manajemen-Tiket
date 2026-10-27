<x-layouts.admin title="Detail Pemesanan">
    <div class="min-h-screen bg-slate-50/50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl space-y-6">

            {{-- Header --}}
            <div>
                <a href="{{ route('admin.histories.index') }}"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" />
                    </svg>
                    Kembali ke History Pembelian
                </a>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                            <span>Administrasi</span>
                            <span>/</span>
                            <a href="{{ route('admin.histories.index') }}" class="hover:text-blue-600">History
                                Pembelian</a>
                            <span>/</span>
                            <span class="font-medium text-blue-600">Detail</span>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Detail Pemesanan
                        </h1>
                        <p class="mt-2 text-sm text-slate-500">
                            Informasi lengkap mengenai transaksi dan tiket yang dibeli.
                        </p>
                    </div>

                    <div
                        class="inline-flex items-center gap-3 self-start rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M7 4h10l3 3v13H4V4h3Zm2 0v5h6V4M8 15h8m-8 3h5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Nomor Pesanan</p>
                            <p class="font-bold text-slate-900">#{{ $order->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order information --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Event card --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-1">
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        <img src="{{ $order->event?->gambar ? asset($order->event->gambar) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                            alt="{{ $order->event?->judul ?? 'Event' }}" class="h-full w-full object-cover" />
                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/60 via-transparent to-transparent">
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span
                                class="inline-flex rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700">
                                Informasi Event
                            </span>
                        </div>
                    </div>

                    <div class="space-y-5 p-5">
                        <div>
                            <h2 class="text-lg font-bold leading-snug text-slate-900">
                                {{ $order->event?->judul ?? 'Event tidak tersedia' }}
                            </h2>
                            <div class="mt-3 flex items-start gap-2 text-sm text-slate-500">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 21s7-5.5 7-12a7 7 0 1 0-14 0c0 6.5 7 12 7 12Z" />
                                    <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />
                                </svg>
                                <span>
                                    {{ $order->event?->lokasi?->nama_lokasi ?? 'Lokasi tidak tersedia' }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Tanggal Transaksi
                            </p>
                            <div class="mt-2 flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ $order->order_date?->format('d M Y') ?? ($order->created_at?->format('d M Y') ?? '-') }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $order->order_date?->format('H:i') ?? ($order->created_at?->format('H:i') ?? '') }}
                                        WIB
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($order->user)
                            <div class="border-t border-slate-100 pt-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Informasi Pembeli
                                </p>
                                <div class="mt-3 flex items-center gap-3">
                                    <div
                                        class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-100 font-bold uppercase text-blue-700">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-800">
                                            {{ $order->user->name }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            Pembeli tiket
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Ticket details --}}
                <div class="space-y-6 lg:col-span-2">

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <h2 class="text-base font-bold text-slate-900">
                                        Rincian Tiket
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Daftar tiket dalam pesanan ini.
                                    </p>
                                </div>

                                <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                    {{ $order->detailOrders->sum('jumlah') }} tiket
                                </span>
                            </div>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse ($order->detailOrders as $d)
                                <div
                                    class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V7Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    stroke-dasharray="2 2" d="M14 5v14" />
                                            </svg>
                                        </div>

                                        <div>
                                            <h3 class="font-semibold text-slate-900">
                                                {{ $d->tiket?->tipeTiket?->nama ?? 'Tipe tiket tidak tersedia' }}
                                            </h3>
                                            <p class="mt-1 text-sm text-slate-500">
                                                Jumlah: {{ $d->jumlah }} tiket
                                            </p>
                                        </div>
                                    </div>

                                    <div class="sm:text-right">
                                        <p class="text-xs text-slate-400">Subtotal</p>
                                        <p class="mt-1 text-base font-bold text-slate-900">
                                            Rp {{ number_format($d->subtotal_harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-10 text-center text-sm text-slate-500">
                                    Tidak ada rincian tiket untuk pesanan ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Payment summary --}}
                    <div class="overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
                        <div class="bg-slate-900 px-5 py-4 sm:px-6">
                            <h2 class="font-semibold text-white">Ringkasan Pembayaran</h2>
                            <p class="mt-1 text-sm text-slate-300">
                                Ringkasan total nilai transaksi.
                            </p>
                        </div>

                        <div class="space-y-4 p-5 sm:p-6">
                            <div class="flex items-center justify-between gap-4 text-sm">
                                <span class="text-slate-500">Jumlah tiket</span>
                                <span class="font-semibold text-slate-800">
                                    {{ $order->detailOrders->sum('jumlah') }} tiket
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 text-sm">
                                <span class="text-slate-500">Nomor pesanan</span>
                                <span class="font-semibold text-slate-800">
                                    #{{ $order->id }}
                                </span>
                            </div>

                            <div class="border-t border-dashed border-slate-200 pt-4">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-600">
                                            Total Pembayaran
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Nilai total seluruh tiket dalam pesanan.
                                        </p>
                                    </div>
                                    <p class="text-2xl font-bold tracking-tight text-blue-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                                <a href="{{ route('admin.histories.index') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m15 18-6-6 6-6" />
                                    </svg>
                                    Kembali ke Riwayat
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
