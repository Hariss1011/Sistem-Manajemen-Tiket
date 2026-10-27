<x-layouts.admin title="Edit Event">
    <div class="mx-auto max-w-6xl space-y-6 p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                    <a href="{{ route('admin.events.index') }}" class="transition hover:text-blue-600">
                        Manajemen Event
                    </a>
                    <span>/</span>
                    <a href="{{ route('admin.events.show', $event->id) }}" class="transition hover:text-blue-600">Detail
                        Event</a>
                    <span>/</span>
                    <span class="font-medium text-slate-700">Edit</span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Edit Event
                </h1>
                <p class="mt-2 text-sm text-slate-500">
                    Perbarui informasi event dan simpan perubahan yang diperlukan.
                </p>
            </div>

            <a href="{{ route('admin.events.show', $event->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7M3 12h18" />
                </svg>
                Kembali ke Detail
            </a>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Perubahan belum dapat disimpan.</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form id="eventForm" method="POST" action="{{ route('admin.events.update', $event->id) }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Basic information --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-900">Informasi Event</h2>
                            <p class="mt-1 text-sm text-slate-500">Kelola judul, deskripsi, jadwal, dan kategori event.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-7">
                    <div class="sm:col-span-2">
                        <label for="judul" class="mb-2 block text-sm font-semibold text-slate-700">
                            Judul Event <span class="text-red-500">*</span>
                        </label>
                        <input id="judul" type="text" name="judul" value="{{ old('judul', $event->judul) }}"
                            maxlength="255" placeholder="Contoh: Konser Musik Rock"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required>
                        @error('judul')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">
                            Deskripsi Event <span class="text-red-500">*</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan informasi dan aktivitas event..."
                            class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required>{{ old('deskripsi', $event->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_waktu" class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal dan Waktu <span class="text-red-500">*</span>
                        </label>
                        <input id="tanggal_waktu" type="datetime-local" name="tanggal_waktu"
                            value="{{ old('tanggal_waktu', $event->tanggal_waktu->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required>
                        @error('tanggal_waktu')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lokasi_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Lokasi Event <span class="text-red-500">*</span>
                        </label>
                        <select id="lokasi_id" name="lokasi_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required>
                            <option value="">Pilih lokasi</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}"
                                    {{ (string) old('lokasi_id', $event->lokasi_id) === (string) $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('lokasi_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="kategori_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori Event <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori_id" name="kategori_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ (string) old('kategori_id', $event->kategori_id) === (string) $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Event image --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-900">Gambar Event</h2>
                            <p class="mt-1 text-sm text-slate-500">Ganti gambar jika diperlukan.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    @if ($event->gambar)
                        <div id="currentImageContainer" class="mb-5">
                            <p class="mb-2 text-sm font-semibold text-slate-700">Gambar Saat Ini</p>
                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                <img id="currentImage" src="{{ $event->gambar_url }}"
                                    alt="Gambar event {{ $event->judul }}" class="max-h-96 w-full object-contain">
                            </div>
                        </div>
                    @endif

                    <label for="gambar" class="mb-2 block text-sm font-semibold text-slate-700">
                        Unggah Gambar Baru
                    </label>
                    <input id="gambar" type="file" name="gambar" accept="image/*"
                        class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-600 file:px-4 file:py-3 file:font-semibold file:text-white hover:file:bg-blue-700">

                    <p class="mt-2 text-xs text-slate-500">
                        Kosongkan jika tidak ingin mengganti gambar. Format JPG, JPEG, PNG, maksimal 5 MB.
                    </p>
                    @error('gambar')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div id="imagePreview" class="mt-5 hidden">
                        <p class="mb-2 text-sm font-semibold text-slate-700">Preview Gambar Baru</p>
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                            <img id="previewImg" src="" alt="Preview gambar baru"
                                class="max-h-96 w-full object-contain">
                        </div>
                    </div>
                </div>
            </section>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="reset"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Reset Perubahan
                </button>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            const form = document.getElementById('eventForm');
            if (!form) return;

            const fileInput = document.getElementById('gambar');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const currentImageContainer = document.getElementById('currentImageContainer');
            const currentImage = document.getElementById('currentImage');

            const originalValues = new FormData(form);
            const originalImageSrc = currentImage ? currentImage.src : null;

            fileInput?.addEventListener('change', function() {
                const file = this.files?.[0];

                if (!file) {
                    imagePreview.classList.add('hidden');
                    previewImg.removeAttribute('src');
                    currentImageContainer?.classList.remove('hidden');
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    this.value = '';
                    imagePreview.classList.add('hidden');
                    previewImg.removeAttribute('src');
                    alert('Silakan pilih file gambar yang valid.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImg.src = event.target.result;
                    imagePreview.classList.remove('hidden');
                    currentImageContainer?.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });

            form.addEventListener('reset', () => {
                setTimeout(() => {
                    imagePreview.classList.add('hidden');
                    previewImg.removeAttribute('src');

                    if (currentImageContainer) {
                        currentImageContainer.classList.remove('hidden');
                    }

                    if (currentImage && originalImageSrc) {
                        currentImage.src = originalImageSrc;
                    }
                }, 0);
            });
        })();
    </script>
</x-layouts.admin>
