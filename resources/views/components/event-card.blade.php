@props(['title', 'date', 'location', 'price', 'image', 'href' => null])

@php
    $formattedPrice =
        is_null($price) || $price === ''
            ? 'Harga tidak tersedia'
            : ((float) $price === 0.0
                ? 'Gratis'
                : 'Rp ' . number_format((float) $price, 0, ',', '.'));

    $formattedDate = $date
        ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('d F Y, H.i') . ' WIB'
        : 'Tanggal tidak tersedia';

    if ($image && filter_var($image, FILTER_VALIDATE_URL)) {
        $imageUrl = $image;
    } elseif ($image && file_exists(public_path('storage/' . $image))) {
        $imageUrl = asset('storage/' . $image);
    } else {
        $imageUrl = asset('images/placeholder-event.svg');
    }

    $destination = $href ?: '#';

    $hasPrice = !is_null($price) && $price !== '';
    $isFree = $hasPrice && (float) $price === 0.0;
@endphp

<a href="{{ $destination }}"
    class="group block h-full rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-4">

    <article
        class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 group-hover:-translate-y-1 group-hover:border-blue-200 group-hover:shadow-xl group-hover:shadow-slate-900/8">

        {{-- Gambar --}}
        <div class="relative aspect-3/2 overflow-hidden bg-slate-100">
            <img src="{{ $imageUrl }}" alt="Poster {{ $title }}" loading="lazy"
                onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">

            <div class="absolute inset-0 bg-linear-to-t from-slate-950/30 via-transparent to-slate-950/5"></div>

            <span
                class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full border border-white/60 bg-white/95 px-3 py-1.5 text-[11px] font-bold text-slate-700 shadow-sm backdrop-blur-sm">
                <x-icon name="calendar-days" class="size-3.5 text-blue-600" />
                Informasi acara
            </span>
        </div>

        {{-- Detail acara --}}
        <div class="flex flex-1 flex-col p-4 sm:p-5">
            <h2
                class="line-clamp-2 min-h-13 text-base font-bold leading-snug tracking-tight text-slate-900 transition-colors group-hover:text-blue-700 sm:text-lg">
                {{ $title }}
            </h2>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-blue-50 text-blue-700">
                        <x-icon name="clock" class="size-4" />
                    </span>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-xs text-slate-400">Tanggal dan waktu</p>
                        <p class="mt-1 font-medium leading-relaxed text-slate-700">
                            {{ $formattedDate }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-slate-100 text-slate-600">
                        <x-icon name="pin" class="size-4" />
                    </span>
                    <div class="min-w-0 pt-0.5">
                        <p class="text-xs text-slate-400">Lokasi acara</p>
                        <p class="mt-1 wrap-break-word font-medium leading-relaxed text-slate-700">
                            {{ $location ?: 'Lokasi belum tersedia' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Harga --}}
            <div class="mt-auto flex items-end justify-between gap-3 border-t border-dashed border-slate-200 pt-4">
                <div class="min-w-0">
                    <p class="mb-1 text-xs font-medium text-slate-500">
                        {{ $isFree ? 'Harga tiket' : ($hasPrice ? 'Harga tiket' : 'Informasi harga') }}
                    </p>

                    <p
                        class="warp-break-word text-lg font-extrabold tracking-tight {{ $isFree || $hasPrice ? 'text-blue-700' : 'text-slate-500' }}">
                        {{ $formattedPrice }}
                    </p>
                </div>

                <span
                    class="grid size-10 shrink-0 place-items-center rounded-xl bg-blue-600 text-white shadow-sm shadow-blue-600/20 transition-all duration-200 group-hover:bg-blue-700 group-hover:shadow-md">
                    <x-icon name="chevron" class="size-4 transition-transform group-hover:translate-x-0.5" />
                </span>
            </div>
        </div>
    </article>
</a>
