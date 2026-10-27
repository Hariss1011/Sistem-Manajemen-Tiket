@php
    $compact = $compact ?? false;

    $buttonBase =
        'inline-flex min-h-12 items-center justify-center gap-2 rounded-xl px-4 text-sm font-bold transition duration-200 focus:outline-none focus-visible:ring-4 disabled:cursor-not-allowed disabled:opacity-50';

    $buttonSize = $compact ? 'w-full' : 'mt-5 w-full';

    $primaryStyle =
        'bg-blue-600 text-white shadow-lg shadow-blue-600/20 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-blue-600/30 focus-visible:ring-blue-100';

    $disabledStyle = 'cursor-not-allowed border border-slate-200 bg-slate-100 text-slate-400 shadow-none';
@endphp

@if (!$bisaBeli)
    <button type="button" class="{{ $buttonBase }} {{ $buttonSize }} {{ $disabledStyle }}" disabled>
        @if ($event->is_past)
            <x-icon name="clock" class="size-4 shrink-0" />
            Acara sudah selesai
        @else
            <x-icon name="ticket" class="size-4 shrink-0" />
            Tiket tidak tersedia
        @endif
    </button>
@else
    @auth
        <button type="button" class="{{ $buttonBase }} {{ $buttonSize }} {{ $primaryStyle }}" :disabled="count === 0"
            @click="openCheckout()">
            <x-icon name="ticket" class="size-4 shrink-0" />
            <span>Pilih dan beli tiket</span>
        </button>
    @else
        <a href="{{ route('login') }}" class="{{ $buttonBase }} {{ $buttonSize }} {{ $primaryStyle }}">
            <x-icon name="user" class="size-4 shrink-0" />
            <span>Masuk untuk membeli</span>
        </a>
    @endauth
@endif
