@php $block = ($compact ?? false) ? 'w-full' : 'btn-block mt-5'; @endphp

@if (!$bisaBeli)
    <button type="button" class="btn btn-disabled {{ $block }}" disabled>
        {{ $event->is_past ? 'Acara sudah selesai' : 'Tiket tidak tersedia' }}
    </button>
@else
    @auth
        <button type="button" class="btn btn-primary {{ $block }}" :disabled="count === 0" @click="openCheckout()">Beli
            tiket</button>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary {{ $block }}">Masuk untuk membeli</a>
    @endauth
@endif
