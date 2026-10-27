<x-guest-layout>
    <div class="mb-8">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="mail-check" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Satu langkah lagi
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Verifikasi emailmu
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Terima kasih sudah bergabung dengan BengTix. Buka email yang kamu gunakan saat mendaftar, lalu klik tautan
            verifikasi untuk melanjutkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                <x-icon name="check-circle" class="h-5 w-5" />
            </div>

            <div>
                <p class="text-sm font-bold text-emerald-800">
                    Email verifikasi berhasil dikirim
                </p>

                <p class="mt-1 text-xs leading-5 text-emerald-700">
                    Tautan verifikasi baru telah dikirim ke alamat email yang kamu daftarkan.
                </p>
            </div>
        </div>
    @endif

    <div class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div class="flex gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                <x-icon name="info" class="h-5 w-5" />
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-800">
                    Belum menerima email?
                </p>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Periksa folder spam atau promosi. Jika email belum ditemukan, kamu bisa meminta tautan verifikasi
                    baru.
                </p>
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button
                class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700!">
                Kirim ulang email verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="flex min-h-12 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-4 focus:ring-red-500/10">
                <x-icon name="log-out" class="h-4 w-4" />
                Keluar dari akun
            </button>
        </form>
    </div>
</x-guest-layout>
