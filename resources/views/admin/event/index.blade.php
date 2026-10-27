<x-layouts.admin title="Manajemen Event">
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

            {{-- Header --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                        <span>Administrasi</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                        <span class="font-medium text-blue-600">Manajemen Event</span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Manajemen Event
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Kelola informasi event, kategori, lokasi, dan tiket yang tersedia
                        melalui satu halaman.
                    </p>
                </div>

                <a href="{{ route('admin.events.create') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                    </svg>
                    Tambah Event
                </a>
            </div>

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Event</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ $events->total() }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Seluruh event yang terdaftar
                            </p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 4h8l4 4v12H4V4h4Zm1 0v5h6V4M8 13h8m-8 4h5" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Event di Halaman Ini</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                                {{ $events->count() }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">
                                Data pada halaman saat ini
                            </p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 5h16v14H4zM8 9h8M8 13h5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Event table --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-1 border-b border-slate-200 px-5 py-5 sm:px-6">
                    <h2 class="text-base font-bold text-slate-900">Daftar Event</h2>
                    <p class="text-sm text-slate-500">
                        Informasi event yang sudah tersimpan di dalam sistem.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-237.5 text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-4 font-semibold">No.</th>
                                <th class="px-5 py-4 font-semibold">Informasi Event</th>
                                <th class="px-5 py-4 font-semibold">Kategori</th>
                                <th class="px-5 py-4 font-semibold">Tanggal</th>
                                <th class="px-5 py-4 font-semibold">Lokasi</th>
                                <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($events as $index => $event)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                                        {{ $events->firstItem() + $index }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-14 w-20 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                                                @if ($event->gambar)
                                                    <img src="{{ $event->gambar_url }}" alt="{{ $event->judul }}"
                                                        class="h-full w-full object-cover" loading="lazy">
                                                @else
                                                    <div
                                                        class="flex h-full w-full items-center justify-center text-slate-400">
                                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.6"
                                                                d="M4 5h16v14H4zM8 13l3-3 5 6M8 9h.01" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="max-w-xs">
                                                <p class="font-semibold leading-5 text-slate-900">
                                                    {{ $event->judul }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-400">
                                                    Event #{{ $event->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span
                                            class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                                            {{ $event->kategori?->nama ?? 'Tanpa kategori' }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4">
                                        <div class="flex items-center gap-2 text-slate-700">
                                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />
                                            </svg>
                                            {{ $event->tanggal_waktu?->format('d M Y') ?? '-' }}
                                        </div>
                                        <p class="mt-1 pl-6 text-xs text-slate-400">
                                            {{ $event->tanggal_waktu?->format('H:i') ?? '' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-start gap-2 text-slate-600">
                                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 21s7-5.5 7-12a7 7 0 1 0-14 0c0 6.5 7 12 7 12Z" />
                                                <circle cx="12" cy="9" r="2.5" stroke-width="1.8" />
                                            </svg>
                                            <span class="max-w-37.5">
                                                {{ $event->lokasi?->nama_lokasi ?? 'Lokasi belum ditentukan' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.events.show', $event->id) }}"
                                                title="Lihat detail"
                                                class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z" />
                                                </svg>
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.events.edit', $event->id) }}" title="Edit event"
                                                class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-blue-600 px-3 text-xs font-semibold text-white transition hover:bg-blue-700">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="m16.5 3.5 4 4M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <button type="button" onclick="openDeleteModal(this)"
                                                data-id="{{ $event->id }}" data-nama="{{ $event->judul }}"
                                                title="Hapus event"
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
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.7" d="M4 5h16v14H4zM8 9h8M8 13h5" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-slate-800">
                                            Belum ada event
                                        </h3>
                                        <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">
                                            Tambahkan event pertama agar informasi dan tiketnya dapat dikelola di sini.
                                        </p>
                                        <a href="{{ route('admin.events.create') }}"
                                            class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v14m-7-7h14" />
                                            </svg>
                                            Tambah Event
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($events->hasPages())
                    <div
                        class="flex flex-col gap-3 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <p class="text-sm text-slate-500">
                            Menampilkan
                            <span class="font-semibold text-slate-700">{{ $events->firstItem() }}</span>
                            sampai
                            <span class="font-semibold text-slate-700">{{ $events->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700">{{ $events->total() }}</span>
                            event
                        </p>
                        <div>{{ $events->links() }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delete confirmation modal --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box max-w-md rounded-2xl p-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 9v4m0 4h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3l-7.5-13.1a2 2 0 0 0-3.4 0Z" />
                </svg>
            </div>

            <h3 class="mt-4 text-lg font-bold text-slate-900">Hapus Event?</h3>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Anda akan menghapus event
                <span id="delete_event_name" class="font-semibold text-slate-800"></span>.
                Pastikan tindakan ini memang diperlukan.
            </p>

            <form id="deleteEventForm" method="POST" class="mt-6">
                @csrf
                @method('DELETE')
                <input type="hidden" name="event_id" id="delete_event_id">

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button" onclick="document.getElementById('delete_modal').close()"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                        Ya, Hapus Event
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button aria-label="Tutup">close</button>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const nama = button.dataset.nama || 'event ini';
            const modal = document.getElementById('delete_modal');
            const form = document.getElementById('deleteEventForm');

            document.getElementById('delete_event_id').value = id;
            document.getElementById('delete_event_name').textContent = '"' + nama + '"';
            form.action = @json(url('/admin/events')) + '/' + encodeURIComponent(id);

            modal.showModal();
        }
    </script>
</x-layouts.admin>
