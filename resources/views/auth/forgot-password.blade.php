<x-guest-layout>
    <div class="mb-8">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="mail" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Pemulihan akun
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Lupa kata sandi?
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Jangan khawatir. Masukkan alamat email yang terdaftar dan kami akan mengirimkan tautan untuk membuat kata
            sandi baru.
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat email terdaftar"
                class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="email"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="nama@email.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button
            class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700!">
            Kirim tautan pemulihan
        </x-primary-button>

        <a href="{{ route('login') }}"
            class="flex min-h-12 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50/50 hover:text-blue-700">
            <x-icon name="arrow-left" class="h-4 w-4" />
            Kembali ke halaman masuk
        </a>
    </form>

    <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <p class="text-xs leading-5 text-slate-500">
            <span class="font-semibold text-slate-700">Tips:</span>
            Periksa juga folder spam jika email pemulihan belum muncul di kotak masuk.
        </p>
    </div>
</x-guest-layout>
