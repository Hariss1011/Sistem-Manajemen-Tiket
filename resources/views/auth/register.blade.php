<x-guest-layout>
    <h1 class="text-2xl font-extrabold tracking-tight">Buat akun BengTix</h1>
    <p class="mt-1 text-sm text-base-content/70">Cukup satu akun untuk memesan tiket semua acara.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input id="name" class="mt-1" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Ulangi kata sandi" />
            <x-text-input id="password_confirmation" class="mt-1" type="password" name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="btn-block">Daftar</x-primary-button>

        <p class="text-center text-sm">
            Sudah punya akun? <a class="link link-primary font-semibold" href="{{ route('login') }}">Masuk</a>
        </p>
    </form>
</x-guest-layout>
