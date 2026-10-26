<footer class="mt-16 border-t border-base-300 bg-base-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.4fr_1fr_1fr]">
        <div>
            <x-brand />
            <p class="mt-3 max-w-xs text-sm leading-relaxed text-base-content/70">
                Platform pemesanan tiket konser, seminar, dan workshop.
            </p>
        </div>

        <nav aria-label="Jelajahi">
            <h2 class="text-sm font-bold">Jelajahi</h2>
            <ul class="mt-3 space-y-2 text-sm text-base-content/70">
                <li><a class="link link-hover" href="{{ route('home') }}#jelajah">Semua acara</a></li>
                @foreach (\App\Models\Kategori::orderBy('nama')->get() as $kategori)
                    <li><a class="link link-hover"
                            href="{{ route('home', ['kategori' => $kategori->id]) }}#jelajah">{{ $kategori->nama }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div>
            <h2 class="text-sm font-bold">Tentang proyek</h2>
            <p class="mt-3 max-w-xs text-sm leading-relaxed text-base-content/70">
                Proyek portofolio sistem tiketing berbasis Laravel, dibuat oleh Haris.
            </p>
            <a class="link link-hover mt-2 inline-block text-sm font-semibold text-primary"
                href="https://github.com/Hariss1011/Sistem-Manajemen-Tiket" target="_blank" rel="noopener">Lihat kode di
                GitHub</a>
        </div>
    </div>
    <div class="border-t border-base-300 py-4 text-center text-xs text-base-content/60">
        © {{ date('Y') }} BengTix
    </div>
</footer>
