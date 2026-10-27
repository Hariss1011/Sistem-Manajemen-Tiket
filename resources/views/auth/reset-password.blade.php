<x-guest-layout>
    <div class="mb-8">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="key-round" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Pemulihan akun
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Buat kata sandi baru
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Gunakan kata sandi baru untuk mengamankan akun BengTix kamu.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Alamat email" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="email"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                placeholder="nama@email.com" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi baru" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="password"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password" required autocomplete="new-password"
                placeholder="Masukkan kata sandi baru" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi kata sandi"
                class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="password_confirmation"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi kata sandi baru" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button
            class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700!">
            Simpan kata sandi baru
        </x-primary-button>

        <p class="text-center text-xs leading-5 text-slate-400">
            Pastikan kedua kolom kata sandi diisi dengan nilai yang sama.
        </p>
    </form>
</x-guest-layout>
