@props(['event'])

@php
    $min = $event->tikets_min_harga;

    $habis = ($event->tikets_count ?? 0) > 0 && (int) ($event->tikets_sum_stok ?? 0) <= 0;

    $selesai = $event->is_past;

    $hari = (int) now()
        ->startOfDay()
        ->diffInDays($event->tanggal_waktu->copy()->startOfDay(), false);

    $tanggal = $event->tanggal_waktu->copy()->locale('id');

    $harga = is_null($min)
        ? 'Tiket belum dibuka'
        : ((float) $min === 0.0
            ? 'Gratis'
            : 'Rp ' . number_format($min, 0, ',', '.'));

    $mulaiDari = !is_null($min) && (float) $min > 0;

    $badge = match (true) {
        $selesai => ['Selesai', 'bg-slate-900/90 text-white'],
        $habis => ['Tiket habis', 'bg-rose-600 text-white'],
        $hari === 0 => ['Hari ini', 'bg-blue-600 text-white'],
        $hari > 0 && $hari <= 7 => [$hari . ' hari lagi', 'bg-amber-100 text-amber-800'],
        default => null,
    };
@endphp

<a href="{{ route('events.show', $event) }}"
    class="ticket-wrap group block h-full rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-4">

    <article
        class="ticket flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-slate-900/8 {{ $selesai || $habis ? 'opacity-90' : '' }}">

        {{-- Gambar acara --}}
        <div class="relative aspect-3/2 overflow-hidden bg-slate-100">
            <img src="{{ $event->gambar_url }}" alt="Poster {{ $event->judul }}" loading="lazy"
                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04] {{ $selesai ? 'grayscale' : '' }}">

            <div class="absolute inset-0 bg-linear-to-t from-slate-950/35 via-transparent to-slate-950/10"></div>

            {{-- Tanggal --}}
            <div
                class="absolute left-3 top-3 min-w-13.5 rounded-xl border border-white/70 bg-white/95 px-2.5 py-2 text-center shadow-lg shadow-slate-950/10 backdrop-blur-sm">
                <div class="text-xl font-extrabold leading-none tracking-tight text-slate-900">
                    {{ $tanggal->format('d') }}
                </div>
                <div class="mt-1 text-[10px] font-bold uppercase tracking-wider text-blue-700">
                    {{ $tanggal->translatedFormat('M') }}
                </div>
            </div>

            {{-- Status --}}
            @if ($badge)
                <span
                    class="absolute right-3 top-3 rounded-full px-3 py-1.5 text-[11px] font-bold shadow-sm {{ $badge[1] }}">
                    {{ $badge[0] }}
                </span>
            @endif

            {{-- Kategori --}}
            @if ($event->kategori)
                <span
                    class="absolute bottom-3 left-3 inline-flex max-w-[calc(100%-24px)] items-center gap-1.5 truncate rounded-full border border-white/50 bg-white/95 px-3 py-1.5 text-[11px] font-bold text-slate-700 shadow-sm backdrop-blur-sm">
                    <x-icon name="tag" class="size-3.5 shrink-0 text-blue-600" />
                    <span class="truncate">{{ $event->kategori->nama }}</span>
                </span>
            @endif
        </div>

        {{-- Informasi acara --}}
        <div class="flex flex-1 flex-col space-y-3 p-4 sm:p-5">
            <h3
                class="line-clamp-2 min-h-13 text-base font-bold leading-snug tracking-tight text-slate-900 transition-colors group-hover:text-blue-700 sm:text-lg">
                {{ $event->judul }}
            </h3>

            <div class="space-y-2.5 text-sm text-slate-500">
                <p class="flex items-center gap-2.5">
                    <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-blue-50 text-blue-700">
                        <x-icon name="clock" class="size-4" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-xs text-slate-400">Waktu acara</span>
                        <span class="block font-medium text-slate-700">
                            {{ $tanggal->translatedFormat('l, H.i') }} WIB
                        </span>
                    </span>
                </p>

                <p class="flex items-center gap-2.5">
                    <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-slate-100 text-slate-600">
                        <x-icon name="pin" class="size-4" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-xs text-slate-400">Lokasi</span>
                        <span class="block truncate font-medium text-slate-700">
                            {{ $event->lokasi?->nama_lokasi ?? 'Lokasi belum tersedia' }}
                        </span>
                    </span>
                </p>
            </div>
        </div>

        {{-- Harga dan tautan --}}
        <div
            class="ticket-stub mt-auto flex items-center justify-between gap-3 border-t border-dashed border-slate-200 bg-slate-50/80 px-4 py-4 sm:px-5">
            <div class="min-w-0 leading-tight">
                @if ($mulaiDari)
                    <p class="mb-1 text-xs font-medium text-slate-500">Mulai dari</p>
                @endif

                <p
                    class="wrap-break-word font-extrabold tracking-tight {{ $mulaiDari || $harga === 'Gratis' ? 'text-lg text-blue-700' : 'text-sm text-slate-600' }}">
                    {{ $harga }}
                </p>
            </div>

            <span
                class="grid size-10 shrink-0 place-items-center rounded-xl bg-blue-600 text-white shadow-sm shadow-blue-600/20 transition-all duration-200 group-hover:bg-blue-700 group-hover:shadow-md">
                <x-icon name="chevron" class="size-4 transition-transform group-hover:translate-x-0.5" />
            </span>
        </div>
    </article>
</a>
