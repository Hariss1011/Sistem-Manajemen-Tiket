<x-layouts.app title="Pesanan saya">
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6">
        <h1 class="text-3xl font-extrabold tracking-tight">Pesanan saya</h1>
        <p class="mt-1 text-base-content/70">Semua tiket yang pernah kamu pesan.</p>

        <div class="mt-8 space-y-4">
            @forelse ($orders as $order)
                @php
                    $event = $order->event;
                    $tgl = $event?->tanggal_waktu?->copy()->locale('id');
                @endphp
                <a href="{{ route('orders.show', $order) }}"
                    class="group flex gap-4 rounded-box border border-base-300 bg-base-100 p-3 hover:border-primary sm:p-4">
                    <img src="{{ $event?->gambar_url }}" alt=""
                        onerror="this.onerror=null;this.src='{{ asset('images/placeholder-event.svg') }}'"
                        class="size-20 shrink-0 rounded-lg object-cover sm:h-24 sm:w-32">

                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-base-content/60">Pesanan #{{ $order->id }} ·
                            {{ $order->order_date->locale('id')->translatedFormat('d M Y, H.i') }}</p>
                        <h2 class="mt-0.5 line-clamp-1 text-lg font-bold group-hover:text-primary">
                            {{ $event?->judul ?? 'Event dihapus' }}</h2>
                        @if ($tgl)
                            <p class="mt-0.5 text-sm text-base-content/70">
                                {{ $tgl->translatedFormat('d F Y') }}
                                @if ($event->is_past)
                                    <span class="badge badge-neutral badge-sm ml-1">Selesai</span>
                                @endif
                            </p>
                        @endif
                    </div>

                    <div class="hidden flex-col items-end justify-center text-right sm:flex">
                        <p class="text-xs text-base-content/60">Total</p>
                        <p class="text-lg font-extrabold text-primary">
                            {{ (float) $order->total_harga === 0.0 ? 'Gratis' : 'Rp ' . number_format($order->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="rounded-box border border-dashed border-base-300 bg-base-100 px-6 py-16 text-center">
                    <p class="text-lg font-bold">Kamu belum punya pesanan.</p>
                    <p class="mt-1 text-base-content/70">Pilih acara yang menarik dan pesan tiket pertamamu.</p>
                    <a href="{{ route('home') }}#jelajah" class="btn btn-primary btn-sm mt-5">Jelajahi acara</a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    </section>
</x-layouts.app>
