<x-layouts.admin title="Manajemen Tipe Tiket">
    @if (session('success'))
        <div id="success-toast" class="toast toast-top toast-end z-100">
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-white px-5 py-4 text-sm text-slate-700 shadow-lg">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Berhasil</p>
                    <p class="mt-0.5 text-slate-500">{{ session('success') }}</p>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => document.getElementById('success-toast')?.remove(), 3000);
        </script>
    @endif

    <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

        {{-- Page heading --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                    <span>Administrasi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="font-medium text-blue-600">Tipe Tiket</span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Manajemen Tipe Tiket
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Atur jenis tiket yang tersedia untuk membantu pengelolaan penjualan dan akses event.
                </p>
            </div>

            <button type="button" onclick="document.getElementById('add_modal').showModal()"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                </svg>
                Tambah Tipe Tiket
            </button>
        </div>

        {{-- Summary cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Tipe Tiket</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                            {{ $tipeTikets->count() }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">Jenis tiket yang terdaftar</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 000-4V8zM9 6v2m0 3v2m0 3v2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Status Pengelolaan</p>
                        <p class="mt-2 text-xl font-bold text-slate-900">Aktif</p>
                        <p class="mt-1 text-xs text-slate-500">Tipe tiket dapat dikelola admin</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5-1.5a8 8 0 11-16 0 8 8 0 0116 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-5 sm:px-6">
                <h2 class="text-base font-bold text-slate-900">Daftar Tipe Tiket</h2>
                <p class="text-sm text-slate-500">Kelola nama jenis tiket yang digunakan pada event BengTix.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-150 text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="w-20 px-6 py-4 font-semibold">No.</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Nama Tipe Tiket</th>
                            <th scope="col" class="w-48 px-6 py-4 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tipeTikets as $index => $tipeTiket)
                            <tr class="transition hover:bg-slate-50/80">
                                <td class="px-6 py-4 text-slate-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 8a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 000-4V8zM9 6v2m0 3v2m0 3v2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $tipeTiket->nama }}</p>
                                            <p class="mt-0.5 text-xs text-slate-400">Jenis tiket event</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="openEditModal(this)"
                                            data-id="{{ $tipeTiket->id }}" data-nama="{{ $tipeTiket->nama }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l2.651 2.651M5 19l4.5-1 9.8-9.8a1.875 1.875 0 00-2.65-2.65l-9.8 9.8L5 19z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button type="button" onclick="openDeleteModal(this)"
                                            data-id="{{ $tipeTiket->id }}" data-nama="{{ $tipeTiket->nama }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-rose-100 bg-white px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 7h12m-10 0l.7 12h6.6L16 7M9 7V4h6v3m-5 4v5m4-5v5" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 000-4V8z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 font-semibold text-slate-800">Belum ada tipe tiket</h3>
                                    <p class="mt-1 text-sm text-slate-500">Tambahkan tipe tiket agar dapat digunakan
                                        pada event.</p>
                                    <button type="button" onclick="document.getElementById('add_modal').showModal()"
                                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                                        </svg>
                                        Tambah Tipe Tiket
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-col gap-1 border-t border-slate-100 bg-slate-50/70 px-5 py-3 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <span>Data tipe tiket BengTix</span>
                <span>Total: <strong class="text-slate-700">{{ $tipeTikets->count() }}</strong> tipe tiket</span>
            </div>
        </section>
    </div>

    {{-- Add modal --}}
    <dialog id="add_modal" class="modal">
        <div class="modal-box max-w-md rounded-2xl p-0 shadow-2xl">
            <form method="POST" action="{{ route('admin.tipe_tiket.store') }}">
                @csrf
                <div class="border-b border-slate-100 px-6 py-5">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Tambah Tipe Tiket</h3>
                            <p class="mt-1 text-sm text-slate-500">Masukkan nama tipe tiket baru.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 px-6 py-5">
                    <label for="add_tipe_tiket_name" class="block text-sm font-semibold text-slate-700">Nama Tipe
                        Tiket</label>
                    <input id="add_tipe_tiket_name" type="text" name="nama" required maxlength="255"
                        placeholder="Contoh: Reguler, VIP, VVIP"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                </div>
                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button type="button" onclick="document.getElementById('add_modal').close()"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Tipe Tiket
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Edit modal --}}
    <dialog id="edit_modal" class="modal">
        <div class="modal-box max-w-md rounded-2xl p-0 shadow-2xl">
            <form id="edit_tipe_tiket_form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe_tiket_id" id="edit_tipe_tiket_id">

                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-900">Edit Tipe Tiket</h3>
                    <p class="mt-1 text-sm text-slate-500">Perbarui nama tipe tiket yang dipilih.</p>
                </div>
                <div class="space-y-2 px-6 py-5">
                    <label for="edit_tipe_tiket_name" class="block text-sm font-semibold text-slate-700">Nama Tipe
                        Tiket</label>
                    <input type="text" id="edit_tipe_tiket_name" name="nama" required maxlength="255"
                        placeholder="Masukkan nama tipe tiket"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                </div>
                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button type="button" onclick="document.getElementById('edit_modal').close()"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    {{-- Delete modal --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box max-w-md rounded-2xl p-0 shadow-2xl">
            <form id="delete_tipe_tiket_form" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="tipe_tiket_id" id="delete_tipe_tiket_id">

                <div class="px-6 py-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M10.3 3.9L1.8 18.6A1.6 1.6 0 003.2 21h17.6a1.6 1.6 0 001.4-2.4L13.7 3.9a2 2 0 00-3.4 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">Hapus Tipe Tiket?</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Anda akan menghapus tipe tiket
                        <strong id="delete_tipe_tiket_label" class="text-slate-800"></strong>.
                        Pastikan data ini memang tidak lagi diperlukan.
                    </p>
                </div>
                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button type="button" onclick="document.getElementById('delete_modal').close()"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        function openEditModal(button) {
            const id = button.dataset.id;
            const name = button.dataset.nama;
            const form = document.getElementById('edit_tipe_tiket_form');

            document.getElementById('edit_tipe_tiket_id').value = id;
            document.getElementById('edit_tipe_tiket_name').value = name;
            form.action = @json(url('/admin/tipe_tiket')) + '/' + encodeURIComponent(id);

            document.getElementById('edit_modal').showModal();
        }

        function openDeleteModal(button) {
            const id = button.dataset.id;
            const name = button.dataset.nama;
            const form = document.getElementById('delete_tipe_tiket_form');

            document.getElementById('delete_tipe_tiket_id').value = id;
            document.getElementById('delete_tipe_tiket_label').textContent = name;
            form.action = @json(url('/admin/tipe_tiket')) + '/' + encodeURIComponent(id);

            document.getElementById('delete_modal').showModal();
        }
    </script>
</x-layouts.admin>
