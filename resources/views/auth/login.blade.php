<x-guest-layout>
    <h1 class="text-2xl font-extrabold tracking-tight">Masuk ke BengTix</h1>
    <p class="mt-1 text-sm text-base-content/70">Lihat pesanan dan beli tiket dengan akunmu.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm">
            <input id="remember_me" type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="remember">
            Ingat saya di perangkat ini
        </label>

        <x-primary-button class="btn-block">Masuk</x-primary-button>

        <div class="flex items-center justify-between text-sm">
            @if (Route::has('password.request'))
                <a class="link link-hover" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
            <a class="link link-primary font-semibold" href="{{ route('register') }}">Buat akun baru</a>
        </div>
    </form>
</x-guest-layout>
