<x-layouts.admin title="Tambah Lokasi Baru">
    @if ($errors->any())
        <div class="toast toast-bottom toast-center z-50">
            <ul class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <script>
            setTimeout(() => {
                document.querySelector('.toast')?.remove()
            }, 5000)
        </script>
    @endif

    <div class="container mx-auto p-10">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Tambah Lokasi Baru</h2>

                <form id="lokasiForm" class="space-y-4" method="post" action="{{ route('admin.lokasis.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Nama Lokasi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Nama Lokasi</span>
                        </label>
                        <input type="text" name="nama_lokasi" placeholder="Contoh: Stadion Utama"
                            class="input input-bordered w-full" required />
                    </div>

                    <!-- Tombol Submit -->
                    <div class="card-actions justify-end mt-6">
                        <button type="reset" class="btn btn-ghost">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert Success -->
        <div id="successAlert" class="alert alert-success mt-4 hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Lokasi berhasil disimpan!</span>
        </div>
    </div>

    <script>
        const form = document.getElementById('lokasiForm');
        const successAlert = document.getElementById('successAlert');

        // Handle reset
        form.addEventListener('reset', function() {
            imagePreview.classList.add('hidden');
            successAlert.classList.add('hidden');
        });
    </script>
</x-layouts.admin>
