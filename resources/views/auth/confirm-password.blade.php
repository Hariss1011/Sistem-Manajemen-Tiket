<x-guest-layout>
    <div class="mb-8">
        <div
            class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
            <x-icon name="shield-check" class="h-7 w-7" />
        </div>

        <p class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">
            Keamanan akun
        </p>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Konfirmasi kata sandi
        </h1>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Kata sandi" class="mb-2 text-sm font-semibold text-slate-700" />

            <x-text-input id="password"
                class="mt-0! block w-full rounded-xl! border-slate-200! bg-white! px-4! py-3! text-sm! text-slate-900! shadow-sm! transition! placeholder:text-slate-400! focus:border-blue-500! focus:ring-4! focus:ring-blue-500/10!"
                type="password" name="password" required autocomplete="current-password" autofocus
                placeholder="Masukkan kata sandi saat ini" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button
            class="btn-block min-h-12! rounded-xl! border-0! bg-blue-600! text-sm! font-bold! text-white! shadow-lg! shadow-blue-600/20! transition! hover:bg-blue-700!">
            Konfirmasi dan lanjutkan
        </x-primary-button>
    </form>
</x-guest-layout>
