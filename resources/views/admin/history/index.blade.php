<x-layouts.admin title="History Pembelian">
    <div class="min-h-screen bg-slate-50/50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            {{-- Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <span>Administrasi</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                        <span class="font-medium text-blue-600">History Pembelian</span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        History Pembelian
                    </h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Pantau transaksi pembelian tiket dan lihat detail setiap pemesanan.
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 3v18h18M8 16V9m4 7V5m4 11v-4m4 4V8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-500">
                            Total Data
                        </p>
                        <p class="text-xl font-bold text-slate-900">
                            {{ $histories->total() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-1 border-b border-slate-200 px-5 py-5 sm:px-6">
                    <h2 class="text-base font-bold text-slate-900">
                        Daftar Transaksi
                    </h2>
                    <p class="text-sm text-slate-500">
                        Riwayat pemesanan tiket yang tercatat dalam sistem.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-200 text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">No.</th>
                                <th class="px-6 py-4 font-semibold">Pembeli</th>
                                <th class="px-6 py-4 font-semibold">Event</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Pembelian</th>
                                <th class="px-6 py-4 text-right font-semibold">Total Harga</th>
                                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($histories as $index => $history)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="whitespace-nowrap px-6 py-4 text-slate-500">
                                        {{ $histories->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold uppercase text-blue-700">
                                                {{ substr($history->user?->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $history->user?->name ?? 'Pengguna tidak tersedia' }}
                                                </p>
                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    ID Transaksi #{{ $history->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <p class="font-medium text-slate-800">
                                                {{ $history->event?->judul ?? 'Event tidak tersedia' }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />
                                            </svg>
                                            {{ $history->created_at?->format('d M Y') ?? '-' }}
                                        </div>
                                        <p class="mt-1 pl-6 text-xs text-slate-400">
                                            {{ $history->created_at?->format('H:i') ?? '' }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($history->total_harga, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.histories.show', $history->id) }}"
                                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                    d="M4 5h16v14H4zM8 9h8M8 13h5" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-slate-800">
                                            Belum ada riwayat pembelian
                                        </h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Data transaksi akan muncul di halaman ini setelah pembelian tercatat.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($histories->hasPages())
                    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-slate-500">
                                Menampilkan
                                <span class="font-semibold text-slate-700">{{ $histories->firstItem() }}</span>
                                sampai
                                <span class="font-semibold text-slate-700">{{ $histories->lastItem() }}</span>
                                dari
                                <span class="font-semibold text-slate-700">{{ $histories->total() }}</span>
                                transaksi
                            </p>

                            <div class="text-sm">
                                {{ $histories->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layouts.admin>
