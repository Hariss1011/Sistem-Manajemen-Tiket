<x-layouts.admin title="Edit Lokasi">
    <div class="mx-auto w-full max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        {{-- Breadcrumb and heading --}}
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('admin.lokasis.index') }}" class="transition hover:text-blue-600">
                    Manajemen Lokasi
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-blue-600">Edit Lokasi</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Edit Lokasi
            </h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Perbarui informasi lokasi agar data penyelenggaraan event tetap akurat.
            </p>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700" role="alert">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 4h.01M10.3 3.9L1.8 18.6A1.6 1.6 0 003.2 21h17.6a1.6 1.6 0 001.4-2.4L13.7 3.9a2 2 0 00-3.4 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Perubahan belum dapat disimpan</p>
                        <ul class="mt-1 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form card --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-start gap-4 border-b border-slate-100 px-5 py-5 sm:px-7">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l2.651 2.651M5 19l4.5-1 9.8-9.8a1.875 1.875 0 00-2.65-2.65l-9.8 9.8L5 19z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Lokasi</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Ubah informasi lokasi yang dipilih di bawah ini.
                    </p>
                </div>
            </div>

            <form id="lokasiForm" method="POST" action="{{ route('admin.lokasis.update', $lokasi->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-2 px-5 py-6 sm:px-7 sm:py-7">
                    <label for="nama_lokasi" class="block text-sm font-semibold text-slate-700">
                        Nama Lokasi <span class="text-rose-500">*</span>
                    </label>
                    <input id="nama_lokasi" type="text" name="nama_lokasi"
                        value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
                        placeholder="Contoh: Stadion Utama, Jakarta Convention Center" maxlength="255" required
                        autofocus
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('nama_lokasi') border-rose-400 focus:border-rose-500 focus:ring-rose-100 @enderror"
                        aria-describedby="nama_lokasi_help">

                    <p id="nama_lokasi_help" class="text-xs leading-5 text-slate-500">
                        Periksa kembali penulisan nama lokasi sebelum menyimpan perubahan.
                    </p>

                    @error('nama_lokasi')
                        <p class="text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                    <a href="{{ route('admin.lokasis.index') }}"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="reset"
                            class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                            Reset Form
                        </button>
                        <button type="submit"
                            class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50/70 p-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 16v-4m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-900">Informasi</p>
                <p class="mt-1 text-sm leading-5 text-blue-800">
                    Perubahan akan diterapkan setelah Anda memilih Simpan Perubahan dan data berhasil divalidasi.
                </p>
            </div>
        </div>
    </div>
</x-layouts.admin>
