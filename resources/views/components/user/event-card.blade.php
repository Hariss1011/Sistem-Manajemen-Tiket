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
        $selesai => ['Selesai', 'bg-neutral text-neutral-content'],
        $habis => ['Tiket habis', 'bg-neutral text-neutral-content'],
        $hari === 0 => ['Hari ini', 'bg-secondary text-secondary-content'],
        $hari <= 7 => [$hari . ' hari lagi', 'bg-accent text-accent-content'],
        default => null,
    };
@endphp

<a href="{{ route('events.show', $event) }}" class="ticket-wrap group block h-full rounded-box">
    <article class="ticket flex h-full flex-col {{ $selesai || $habis ? 'opacity-85' : '' }}">
        <div class="relative aspect-[3/2] overflow-hidden bg-base-200">
            <img src="{{ $event->gambar_url }}" alt="" loading="lazy"
                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                class="size-full object-cover {{ $selesai ? 'grayscale' : '' }}">

            <div class="absolute left-3 top-3 rounded-lg bg-base-100 px-2.5 py-1.5 text-center leading-none shadow-sm">
                <div class="text-xl font-extrabold">{{ $tanggal->format('d') }}</div>
                <div class="mt-1 text-xs font-bold text-secondary">{{ $tanggal->translatedFormat('M') }}</div>
            </div>

            @if ($badge)
                <span
                    class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-bold {{ $badge[1] }}">{{ $badge[0] }}</span>
            @endif

            @if ($event->kategori)
                <span
                    class="absolute bottom-3 left-3 rounded-full bg-base-100/95 px-3 py-1 text-xs font-semibold">{{ $event->kategori->nama }}</span>
            @endif
        </div>

        <div class="flex-1 space-y-2 p-4">
            <h3 class="line-clamp-2 text-lg font-bold leading-snug text-balance group-hover:text-primary">
                {{ $event->judul }}</h3>
            <p class="flex items-center gap-2 text-sm text-base-content/70">
                <x-icon name="clock" class="size-4 shrink-0" />
                {{ $tanggal->translatedFormat('l, H.i') }} WIB
            </p>
            <p class="flex items-center gap-2 text-sm text-base-content/70">
                <x-icon name="pin" class="size-4 shrink-0" />
                <span class="line-clamp-1">{{ $event->lokasi?->nama_lokasi }}</span>
            </p>
        </div>

        <div class="ticket-stub flex items-center justify-between gap-3 px-4">
            <div class="leading-tight">
                @if ($mulaiDari)
                    <p class="text-xs text-base-content/60">Mulai dari</p>
                @endif
                <p
                    class="text-lg font-extrabold {{ $mulaiDari || $harga === 'Gratis' ? 'text-primary' : 'text-base-content/60 text-base' }}">
                    {{ $harga }}</p>
            </div>
            <span
                class="grid size-9 place-items-center rounded-full bg-primary text-primary-content transition-transform group-hover:translate-x-0.5">
                <x-icon name="chevron" class="size-4" />
            </span>
        </div>
    </article>
</a>
