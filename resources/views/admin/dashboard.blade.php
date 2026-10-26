<x-layouts.admin title="Dashboard">
    <div class="mx-auto max-w-6xl space-y-8 p-6 lg:p-10">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Dashboard</h1>
            <p class="mt-1 text-base-content/70">Ringkasan penjualan tiket BengTix.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-box border border-base-300 bg-base-100 p-5">
                <p class="text-sm text-base-content/70">Pendapatan</p>
                <p class="mt-1 text-3xl font-extrabold text-primary">Rp
                    {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-box border border-base-300 bg-base-100 p-5">
                <p class="text-sm text-base-content/70">Tiket terjual</p>
                <p class="mt-1 text-3xl font-extrabold">{{ number_format($stats['tickets'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-box border border-base-300 bg-base-100 p-5">
                <p class="text-sm text-base-content/70">Pesanan</p>
                <p class="mt-1 text-3xl font-extrabold">{{ number_format($stats['orders'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-box border border-base-300 bg-base-100 p-5">
                <p class="text-sm text-base-content/70">Acara</p>
                <p class="mt-1 text-3xl font-extrabold">{{ $stats['events'] }}</p>
                <p class="mt-0.5 text-xs text-base-content/60">{{ $stats['upcoming'] }} akan datang</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
            <section class="rounded-box border border-base-300 bg-base-100">
                <div class="flex items-center justify-between p-5 pb-3">
                    <h2 class="text-lg font-extrabold">Pesanan terbaru</h2>
                    <a href="{{ route('admin.histories.index') }}" class="link link-primary text-sm font-semibold">Lihat
                        semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pembeli</th>
                                <th>Acara</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td>
                                        <p class="font-semibold">{{ $order->user?->name ?? '-' }}</p>
                                        <p class="text-xs text-base-content/60">
                                            {{ $order->order_date->locale('id')->translatedFormat('d M Y, H.i') }}</p>
                                    </td>
                                    <td class="max-w-56 truncate">{{ $order->event?->judul ?? '-' }}</td>
                                    <td class="text-right font-semibold">Rp
                                        {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-base-content/60">Belum ada pesanan
                                        masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded-box border border-base-300 bg-base-100 p-5">
                <h2 class="text-lg font-extrabold">Acara terlaris</h2>
                <ol class="mt-4 space-y-4">
                    @forelse ($topEvents as $event)
                        <li>
                            <div class="flex items-baseline justify-between gap-3">
                                <a href="{{ route('admin.events.show', $event->id) }}"
                                    class="line-clamp-1 font-semibold hover:text-primary">{{ $event->judul }}</a>
                                <span class="shrink-0 text-sm font-bold">{{ $event->terjual }} tiket</span>
                            </div>
                            <progress class="progress progress-primary mt-1.5 h-1.5 w-full"
                                value="{{ $event->terjual }}" max="{{ $topEvents->first()->terjual }}"></progress>
                            <p class="mt-1 text-xs text-base-content/60">Rp
                                {{ number_format($event->pendapatan, 0, ',', '.') }}</p>
                        </li>
                    @empty
                        <li class="text-sm text-base-content/60">Belum ada penjualan.</li>
                    @endforelse
                </ol>
            </section>
        </div>
    </div>
</x-layouts.admin>
