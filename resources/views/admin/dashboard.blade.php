<x-layouts.admin title="Dashboard">
    <div class="mx-auto max-w-[1440px] space-y-8 p-5 sm:p-7 lg:p-10">

        {{-- Page heading --}}
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm font-semibold text-blue-600">
                    <span class="size-2 rounded-full bg-blue-600"></span>
                    BENGTIX ADMINISTRATION
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Dashboard
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                    Pantau performa penjualan tiket, pesanan terbaru, dan acara unggulan dalam satu tempat.
                </p>
            </div>

            <div
                class="flex items-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm sm:self-auto">
                <span class="flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <x-icon name="calendar-days" />
                </span>
                <div>
                    <p class="text-xs font-medium text-slate-500">Tanggal hari ini</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ now()->locale('id')->translatedFormat('d M Y') }}
                    </p>
                </div>
            </div>
        </header>

        {{-- Overview metrics --}}
        <section aria-label="Ringkasan statistik" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Revenue: primary metric --}}
            <article
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#172554] to-blue-800 p-5 text-white shadow-lg shadow-blue-950/10 sm:p-6">
                <div class="absolute -right-8 -top-8 size-32 rounded-full bg-white/5"></div>
                <div class="absolute -bottom-12 right-12 size-28 rounded-full bg-blue-400/10"></div>

                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Total Pendapatan</p>
                        <p class="mt-4 break-words text-2xl font-extrabold tracking-tight sm:text-3xl">
                            Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
                        </p>
                    </div>

                    <span
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/15">
                        <x-icon name="wallet" />
                    </span>
                </div>

                <div class="relative mt-5 flex items-center gap-2 border-t border-white/15 pt-4 text-xs text-blue-100">
                    <x-icon name="chart-no-axes-combined" />
                    <span>Akumulasi pendapatan tercatat</span>
                </div>
            </article>

            {{-- Tickets --}}
            <article
                class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Tiket Terjual</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                            {{ number_format($stats['tickets'], 0, ',', '.') }}
                        </p>
                    </div>

                    <span class="flex size-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <x-icon name="ticket" />
                    </span>
                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-500">Total tiket yang telah terjual</p>
                </div>
            </article>

            {{-- Orders --}}
            <article
                class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pesanan</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                            {{ number_format($stats['orders'], 0, ',', '.') }}
                        </p>
                    </div>

                    <span class="flex size-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <x-icon name="shopping-bag" />
                    </span>
                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-500">Jumlah pesanan tercatat</p>
                </div>
            </article>

            {{-- Events --}}
            <article
                class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Acara</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                            {{ number_format($stats['events'], 0, ',', '.') }}
                        </p>
                    </div>

                    <span class="flex size-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <x-icon name="calendar-days" />
                    </span>
                </div>

                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                    <span class="size-2 rounded-full bg-emerald-500"></span>
                    <p class="text-xs text-slate-500">
                        <span class="font-bold text-emerald-600">{{ $stats['upcoming'] }}</span>
                        acara akan datang
                    </p>
                </div>
            </article>
        </section>

        {{-- Main content --}}
        <div class="grid items-start gap-6 xl:grid-cols-[minmax(0,1.55fr)_minmax(320px,0.85fr)]">

            {{-- Recent orders --}}
            <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div
                    class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <x-icon name="receipt-text" />
                            </span>
                            <h2 class="text-lg font-extrabold tracking-tight text-slate-900">
                                Pesanan Terbaru
                            </h2>
                        </div>
                        <p class="mt-2 text-sm text-slate-500">
                            Aktivitas pesanan yang baru tercatat di BengTix.
                        </p>
                    </div>

                    <a href="{{ route('admin.histories.index') }}"
                        class="inline-flex items-center justify-center gap-2 self-start rounded-lg border border-slate-200 px-3.5 py-2 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 sm:self-auto">
                        Lihat semua
                        <x-icon name="arrow-up-right" />
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[520px] text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500">
                                <th class="px-5 py-3.5 font-semibold sm:px-6">Pembeli</th>
                                <th class="px-5 py-3.5 font-semibold">Acara</th>
                                <th class="px-5 py-3.5 text-right font-semibold sm:px-6">Total</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentOrders as $order)
                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="font-bold text-slate-800">
                                            {{ $order->user?->name ?? '-' }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $order->order_date->locale('id')->translatedFormat('d M Y, H.i') }}
                                        </p>
                                    </td>

                                    <td class="max-w-56 px-5 py-4">
                                        <p class="truncate font-medium text-slate-700"
                                            title="{{ $order->event?->judul ?? '-' }}">
                                            {{ $order->event?->judul ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-right sm:px-6">
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-14 text-center">
                                        <span
                                            class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <x-icon name="inbox" />
                                        </span>
                                        <p class="mt-3 font-semibold text-slate-700">
                                            Belum ada pesanan
                                        </p>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Pesanan terbaru akan muncul di bagian ini.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($recentOrders->isNotEmpty())
                    <div class="border-t border-slate-100 px-5 py-3.5 sm:px-6">
                        <p class="text-xs text-slate-500">
                            Menampilkan pesanan terbaru yang tersedia.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Top events --}}
            <section class="min-w-0 rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-2">
                        <span class="flex size-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <x-icon name="trophy" />
                        </span>
                        <h2 class="text-lg font-extrabold tracking-tight text-slate-900">
                            Acara Terlaris
                        </h2>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">
                        Acara dengan jumlah tiket terjual tertinggi.
                    </p>
                </div>

                <div class="space-y-5 p-5 sm:p-6">
                    @forelse ($topEvents as $index => $event)
                        @php
                            $maxSold = max((int) ($topEvents->first()->terjual ?? 0), 1);
                            $sold = (int) $event->terjual;
                            $percentage = min(100, ($sold / $maxSold) * 100);
                        @endphp

                        <article class="group">
                            <div class="flex items-start gap-3">
                                <span @class([
                                    'flex size-9 shrink-0 items-center justify-center rounded-xl text-sm font-extrabold',
                                    'bg-amber-100 text-amber-700' => $index === 0,
                                    'bg-slate-100 text-slate-600' => $index !== 0,
                                ])>
                                    {{ sprintf('%02d', $index + 1) }}
                                </span>

                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('admin.events.show', $event->id) }}"
                                        class="line-clamp-2 font-bold leading-5 text-slate-800 transition group-hover:text-blue-700">
                                        {{ $event->judul }}
                                    </a>

                                    <div class="mt-2 flex flex-wrap items-center justify-between gap-2">
                                        <span class="text-xs text-slate-500">
                                            {{ number_format($sold, 0, ',', '.') }} tiket terjual
                                        </span>
                                        <span class="text-xs font-bold text-slate-700">
                                            Rp {{ number_format($event->pendapatan, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100" role="progressbar"
                                        aria-label="Perbandingan penjualan {{ $event->judul }}" aria-valuemin="0"
                                        aria-valuemax="100" aria-valuenow="{{ (int) round($percentage) }}">
                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-blue-700 transition-all duration-500"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="py-8 text-center">
                            <span
                                class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                <x-icon name="chart-no-axes-combined" />
                            </span>
                            <p class="mt-3 font-semibold text-slate-700">
                                Belum ada data penjualan
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                Acara terlaris akan ditampilkan setelah tiket terjual.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- Footer note --}}
        <footer
            class="flex flex-col gap-1 border-t border-slate-200 pt-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>BengTix Administration Dashboard</p>
            <p>Ringkasan data penjualan dan pengelolaan acara.</p>
        </footer>
    </div>
</x-layouts.admin>
