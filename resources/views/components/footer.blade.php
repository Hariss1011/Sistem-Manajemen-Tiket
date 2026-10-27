<footer class="mt-16 border-t border-slate-200 bg-white">

    {{-- Konten footer --}}
    <div
        class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 sm:py-14 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr] lg:gap-16 lg:px-8">

        {{-- Identitas BengTix --}}
        <div>
            <a href="{{ route('home') }}" aria-label="BengTix, ke beranda"
                class="inline-flex rounded-xl transition-opacity hover:opacity-80">
                <x-brand />
            </a>

            <p class="mt-4 max-w-sm text-sm leading-7 text-slate-500">
                Temukan pengalaman menarik melalui konser, seminar, dan workshop.
                Pilih acara favoritmu dan pesan tiket dengan mudah melalui BengTix.
            </p>

            <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5">
                <span class="size-2 rounded-full bg-blue-600"></span>
                <span class="text-xs font-semibold text-blue-700">
                    Platform pemesanan tiket
                </span>
            </div>
        </div>

        {{-- Navigasi event --}}
        <nav aria-label="Jelajahi acara">
            <h2 class="text-sm font-bold tracking-wide text-slate-900">
                Jelajahi
            </h2>

            <ul class="mt-4 space-y-3 text-sm text-slate-500">

                <li>
                    <a class="inline-flex items-center gap-2 transition-colors hover:text-blue-600"
                        href="{{ route('home') }}#jelajah">
                        <x-icon name="arrow-up-right" class="size-4" />
                        Semua acara
                    </a>
                </li>

                @foreach (\App\Models\Kategori::orderBy('nama')->get() as $kategori)
                    <li>
                        <a class="inline-flex items-center gap-2 transition-colors hover:text-blue-600"
                            href="{{ route('home', ['kategori' => $kategori->id]) }}#jelajah">
                            <x-icon name="chevron-right" class="size-3.5" />
                            {{ $kategori->nama }}
                        </a>
                    </li>
                @endforeach

            </ul>
        </nav>

        {{-- Informasi proyek --}}
        <div>
            <h2 class="text-sm font-bold tracking-wide text-slate-900">
                Tentang BengTix
            </h2>

            <p class="mt-4 max-w-sm text-sm leading-7 text-slate-500">
                BengTix merupakan proyek portofolio sistem manajemen dan pemesanan tiket
                berbasis Laravel yang dikembangkan oleh Haris.
            </p>

            <a href="https://github.com/Hariss1011/Sistem-Manajemen-Tiket" target="_blank" rel="noopener noreferrer"
                class="mt-5 inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-all duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">

                <x-icon name="github" class="size-4" />
                Lihat proyek di GitHub
                <x-icon name="arrow-up-right" class="size-4" />

            </a>
        </div>

    </div>

    {{-- Copyright --}}
    <div class="border-t border-slate-200 bg-slate-50/80">
        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-5 text-center sm:flex-row sm:px-6 lg:px-8">

            <p class="text-xs text-slate-500">
                © {{ date('Y') }} BengTix. Semua hak cipta dilindungi.
            </p>

            <p class="text-xs font-medium text-slate-400">
                Dibangun dengan Laravel
            </p>

        </div>
    </div>

</footer>
