<x-guest-layout>
    <div class="mb-7">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="ticket" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Mulai pengalamanmu
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Buat akun BengTix
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Daftar sekarang untuk memesan tiket dan mengikuti acara yang kamu sukai.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nama lengkap" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="name"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap" />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat email" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="email"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="nama@email.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="password"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password" required autocomplete="new-password" placeholder="Buat kata sandi" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi kata sandi"
                class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="password_confirmation"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Masukkan ulang kata sandi" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button
                class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700! hover:shadow-blue-700/25!">
                Buat akun
            </x-primary-button>
        </div>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>

            <div class="relative flex justify-center">
                <span class="bg-white px-3 text-xs font-medium text-slate-400">
                    Sudah terdaftar?
                </span>
            </div>
        </div>

        <a href="{{ route('login') }}"
            class="flex min-h-12 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50/50 hover:text-blue-700">
            Masuk ke akun
        </a>

        <p class="px-2 text-center text-xs leading-5 text-slate-400">
            Dengan membuat akun, kamu dapat mengelola pesanan dan mengakses tiket melalui BengTix.
        </p>
    </form>
</x-guest-layout>
