<x-guest-layout>
    <div class="mb-8">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="ticket" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Selamat datang kembali
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Masuk ke BengTix
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Masuk ke akunmu untuk mengelola pesanan dan menemukan acara favorit.
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat email" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="email"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="nama@email.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between gap-3">
                <x-input-label for="password" value="Kata sandi" class="text-sm font-semibold text-slate-700" />

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-semibold text-blue-600 transition hover:text-blue-700">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <x-text-input id="password"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password" required autocomplete="current-password"
                placeholder="Masukkan kata sandi" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me"
            class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3 transition hover:border-blue-200 hover:bg-blue-50/50">
            <input id="remember_me" type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded-md"
                name="remember" value="1" />

            <span class="text-sm font-medium text-slate-600">
                Ingat saya di perangkat ini
            </span>
        </label>

        <x-primary-button
            class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700! hover:shadow-blue-700/25!">
            Masuk ke akun
        </x-primary-button>

        <div class="relative py-1">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>

            <div class="relative flex justify-center">
                <span class="bg-white px-3 text-xs font-medium text-slate-400">
                    Pengguna baru di BengTix?
                </span>
            </div>
        </div>

        <a href="{{ route('register') }}"
            class="flex min-h-12 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50/50 hover:text-blue-700">
            Buat akun baru
        </a>
    </form>
</x-guest-layout>
