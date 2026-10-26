{{-- Logotype BengTix: glyph tiket + nama --}}
<span
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 font-extrabold tracking-tight text-primary']) }}>
    <svg class="size-7 shrink-0" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <path fill="currentColor"
            d="M6 6h20a2 2 0 0 1 2 2v3.2a2.8 2.8 0 0 0 0 5.6V24a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7.2a2.8 2.8 0 0 0 0-5.6V8a2 2 0 0 1 2-2Z" />
        <path stroke="var(--color-secondary)" stroke-width="2.2" stroke-linecap="round" stroke-dasharray="0.1 4.2"
            d="M19.5 9v14" />
    </svg>
    <span class="text-xl leading-none">BengTix</span>
</span>
