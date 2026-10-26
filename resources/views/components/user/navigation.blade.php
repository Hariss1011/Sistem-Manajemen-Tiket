<header class="sticky top-0 z-40 border-b border-base-300 bg-base-100/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center gap-2 px-4 sm:px-6">
        <a href="{{ route('home') }}" aria-label="BengTix, ke beranda" class="rounded-lg">
            <x-brand />
        </a>

        <nav class="ml-6 hidden items-center gap-1 text-sm font-semibold md:flex" aria-label="Menu utama">
            <a href="{{ route('home') }}#jelajah"
                class="btn btn-ghost btn-sm {{ request()->routeIs('home', 'events.*') ? 'text-primary' : '' }}">Jelajahi
                acara</a>
            @auth
                <a href="{{ route('orders.index') }}"
                    class="btn btn-ghost btn-sm {{ request()->routeIs('orders.*') ? 'text-primary' : '' }}">Pesanan saya</a>
            @endauth
        </nav>

        <div class="ml-auto flex items-center gap-2">
            @guest
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @endguest

            @auth
                <div class="dropdown dropdown-end">
                    <button type="button" tabindex="0" class="btn btn-ghost btn-sm gap-2 px-2"
                        aria-label="Menu akun {{ Auth::user()->name }}">
                        <span
                            class="grid size-7 place-items-center rounded-full bg-primary text-xs font-bold text-primary-content">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span class="hidden max-w-32 truncate sm:inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul tabindex="0"
                        class="menu dropdown-content z-50 mt-2 w-56 rounded-box border border-base-300 bg-base-100 p-2 shadow-lg">
                        <li><a href="{{ route('orders.index') }}"><x-icon name="ticket" /> Pesanan saya</a></li>
                        <li><a href="{{ route('profile.edit') }}"><x-icon name="user" /> Profil</a></li>
                        @if (Auth::user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}">Panel admin</a></li>
                        @endif
                        <li class="mt-1 border-t border-base-300 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</header>
