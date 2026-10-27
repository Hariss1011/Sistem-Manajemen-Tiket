<x-layouts.admin title="Detail Event">
    @if (session('success'))
        <div id="success-toast" class="toast toast-bottom toast-end z-50">
            <div class="alert border border-emerald-200 bg-white text-emerald-800 shadow-lg">
                <svg class="h-6 w-6 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => document.getElementById('success-toast')?.remove(), 3000);
        </script>
    @endif

    <div class="min-h-screen bg-slate-50/50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            {{-- Page heading --}}
            <div>
                <a href="{{ route('admin.events.index') }}"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" />
                    </svg>
                    Kembali ke Manajemen Event
                </a>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                            <span>Administrasi</span>
                            <span>/</span>
                            <a href="{{ route('admin.events.index') }}" class="hover:text-blue-600">Manajemen Event</a>
                            <span>/</span>
                            <span class="font-medium text-blue-600">Detail Event</span>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Detail Event
                        </h1>
                        <p class="mt-2 text-sm text-slate-500">
                            Lihat informasi event dan kelola tiket yang tersedia.
                        </p>
                    </div>

                    <a href="{{ route('admin.events.edit', $event->id) }}"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="m16.5 3.5 4 4M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" />
                        </svg>
                        Edit Event
                    </a>
                </div>
            </div>

            {{-- Event information card --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-5">

                    {{-- Image --}}
                    <div class="relative min-h-64 bg-slate-100 lg:col-span-2 lg:min-h-full">
                        @if ($event->gambar)
                            <img src="{{ $event->gambar_url }}" alt="{{ $event->judul }}"
                                class="absolute inset-0 h-full w-full object-cover">
                        @else
                            <div class="flex min-h-64 h-full items-center justify-center text-slate-400">
                                <div class="text-center">
                                    <svg class="mx-auto h-14 w-14" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 5h16v14H4zM8 13l3-3 5 6M8 9h.01" />
                                    </svg>
                                    <p class="mt-2 text-sm">Gambar belum tersedia</p>
                                </div>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/60 via-transparent to-transparent">
                        </div>
                        <div class="absolute bottom-5 left-5 right-5">
                            <span
                                class="inline-flex rounded-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-blue-700 shadow-sm">
                                {{ $event->kategori?->nama ?? 'Tanpa kategori' }}
                            </span>
                        </div>
                    </div>

                    {{-- Information --}}
                    <div class="p-5 sm:p-7 lg:col-span-3">
                        <div class="border-b border-slate-100 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                                Informasi Event
                            </p>
                            <h2 class="mt-2 text-2xl font-bold leading-tight tracking-tight text-slate-900">
                                {{ $event->judul }}
                            </h2>
                            <p class="mt-2 text-sm text-slate-400">
                                Event ID #{{ $event->id }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 border-b border-slate-100 py-5 sm:grid-cols-2">
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                                        Tanggal & Waktu
                                    </p>
                                    <p class="mt-1.5 font-semibold text-slate-800">
                                        {{ $event->tanggal_waktu?->format('d M Y') ?? '-' }}
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $event->tanggal_waktu?->format('H:i') ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 21s7-5.5 7-12a7 7 0 1 0-14 0c0 6.5 7 12 7 12Z" />
                                        <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                                        Lokasi
                                    </p>
                                    <p class="mt-1.5 font-semibold text-slate-800">
                                        {{ $event->lokasi?->nama_lokasi ?? 'Belum ditentukan' }}
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Lokasi penyelenggaraan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Deskripsi Event
                            </p>
                            <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600">
                                {{ $event->deskripsi ?: 'Belum ada deskripsi untuk event ini.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ticket management heading --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-900">
                        Manajemen Tiket
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola tipe tiket, harga, dan ketersediaan stok event ini.
                    </p>
                </div>

                <button type="button" onclick="document.getElementById('add_ticket_modal').showModal()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                    Tambah Tiket
                </button>
            </div>

            {{-- Ticket summary --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Jenis Tiket</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $tickets->count() }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Tipe tiket pada event ini
                            </p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V7Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Stok Tiket</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $tickets->sum('stok') }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Total stok dari tiket yang terdaftar
                            </p>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V7Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    stroke-dasharray="2 2" d="M14 5v14" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ticket table --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                    <h3 class="font-bold text-slate-900">Daftar Tiket</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Daftar tiket beserta harga dan stok yang tersedia.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-162.5 text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">No.</th>
                                <th class="px-6 py-4 font-semibold">Tipe Tiket</th>
                                <th class="px-6 py-4 text-right font-semibold">Harga</th>
                                <th class="px-6 py-4 text-center font-semibold">Stok</th>
                                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tickets as $index => $ticket)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V7Z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">
                                                    {{ $ticket->tipeTiket?->nama ?? 'Tipe tiket tidak tersedia' }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-400">
                                                    Tiket #{{ $ticket->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex min-w-14 items-center justify-center rounded-full px-3 py-1.5 text-xs font-bold {{ $ticket->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                            {{ $ticket->stok }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="openEditModal(this)"
                                                data-id="{{ $ticket->id }}"
                                                data-tipe="{{ $ticket->tipe_tiket_id }}"
                                                data-harga="{{ $ticket->harga }}" data-stok="{{ $ticket->stok }}"
                                                class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-blue-600 px-3 text-xs font-semibold text-white transition hover:bg-blue-700">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="m16.5 3.5 4 4M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" />
                                                </svg>
                                                Edit
                                            </button>

                                            <button type="button" onclick="openDeleteModal(this)"
                                                data-id="{{ $ticket->id }}"
                                                data-nama="{{ $ticket->tipeTiket?->nama ?? 'tiket ini' }}"
                                                class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center">
                                        <div
                                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4V7Z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-3 font-semibold text-slate-800">
                                            Belum ada tiket
                                        </h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Tambahkan tipe tiket untuk mulai mengelola harga dan stok.
                                        </p>
                                        <button type="button"
                                            onclick="document.getElementById('add_ticket_modal').showModal()"
                                            class="mt-4 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                            Tambah Tiket
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Add ticket modal --}}
    <dialog id="add_ticket_modal" class="modal">
        <div class="modal-box max-w-lg rounded-2xl p-0">
            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="text-lg font-bold text-slate-900">Tambah Tiket</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Masukkan tipe tiket, harga, dan stok awal.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.tickets.store') }}" class="space-y-5 p-6">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                <div>
                    <label for="add_tipe" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tipe Tiket
                    </label>
                    <select id="add_tipe" name="tipe_tiket_id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                        <option value="" disabled selected>Pilih tipe tiket</option>
                        @foreach ($tipeTikets as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="add_harga" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga Tiket (Rp)
                    </label>
                    <input id="add_harga" type="number" name="harga" min="0" placeholder="Contoh: 50000"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                </div>

                <div>
                    <label for="add_stok" class="mb-2 block text-sm font-semibold text-slate-700">
                        Stok Tiket
                    </label>
                    <input id="add_stok" type="number" name="stok" min="0" placeholder="Contoh: 100"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <button type="button" onclick="document.getElementById('add_ticket_modal').close()"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Tiket
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button aria-label="Tutup">close</button>
        </form>
    </dialog>

    {{-- Edit ticket modal --}}
    <dialog id="edit_ticket_modal" class="modal">
        <div class="modal-box max-w-lg rounded-2xl p-0">
            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="text-lg font-bold text-slate-900">Edit Tiket</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Perbarui informasi tiket yang dipilih.
                </p>
            </div>

            <form method="POST" id="editTicketForm" class="space-y-5 p-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_tipe" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tipe Tiket
                    </label>
                    <select name="tipe_tiket_id" id="edit_tipe"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                        <option value="" disabled>Pilih tipe tiket</option>
                        @foreach ($tipeTikets as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_harga" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga Tiket (Rp)
                    </label>
                    <input type="number" name="harga" id="edit_harga" min="0"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                </div>

                <div>
                    <label for="edit_stok" class="mb-2 block text-sm font-semibold text-slate-700">
                        Stok Tiket
                    </label>
                    <input type="number" name="stok" id="edit_stok" min="0"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        required>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <button type="button" onclick="document.getElementById('edit_ticket_modal').close()"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button aria-label="Tutup">close</button>
        </form>
    </dialog>

    {{-- Delete ticket modal --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box max-w-md rounded-2xl p-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 9v4m0 4h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3l-7.5-13.1a2 2 0 0 0-3.4 0Z" />
                </svg>
            </div>

            <h3 class="mt-4 text-lg font-bold text-slate-900">Hapus Tiket?</h3>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Anda akan menghapus tipe tiket
                <span id="delete_ticket_name" class="font-semibold text-slate-800"></span>.
                Pastikan tindakan ini memang diperlukan.
            </p>

            <form id="deleteTicketForm" method="POST" class="mt-6">
                @csrf
                @method('DELETE')
                <input type="hidden" name="ticket_id" id="delete_ticket_id">

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button" onclick="document.getElementById('delete_modal').close()"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                        Ya, Hapus Tiket
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button aria-label="Tutup">close</button>
        </form>
    </dialog>

    <script>
        function openEditModal(button) {
            const id = button.dataset.id;

            document.getElementById('edit_tipe').value = button.dataset.tipe;
            document.getElementById('edit_harga').value = button.dataset.harga;
            document.getElementById('edit_stok').value = button.dataset.stok;

            document.getElementById('editTicketForm').action =
                @json(url('/admin/tickets')) + '/' + encodeURIComponent(id);

            document.getElementById('edit_ticket_modal').showModal();
        }

        function openDeleteModal(button) {
            const id = button.dataset.id;
            const nama = button.dataset.nama || 'tiket ini';

            document.getElementById('delete_ticket_id').value = id;
            document.getElementById('delete_ticket_name').textContent = '"' + nama + '"';
            document.getElementById('deleteTicketForm').action =
                @json(url('/admin/tickets')) + '/' + encodeURIComponent(id);

            document.getElementById('delete_modal').showModal();
        }
    </script>
</x-layouts.admin>
