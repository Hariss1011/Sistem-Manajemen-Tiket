{{-- Brand BengTix: modern ticket mark + wordmark --}}

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 font-extrabold tracking-tight text-slate-900']) }}>
    <span
        class="inline-flex size-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-600/20">
        <svg class="size-6" viewBox="0 0 32 32" fill="none" aria-hidden="true">
            <path
                d="M6 6.5h20a2 2 0 0 1 2 2v4a3.5 3.5 0 0 0 0 7v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4a3.5 3.5 0 0 0 0-7v-4a2 2 0 0 1 2-2Z"
                fill="currentColor" />
            <path d="M19.5 10v12" stroke="#93C5FD" stroke-width="2" stroke-linecap="round" stroke-dasharray="1 3.5" />
        </svg>
    </span>

    <span class="text-xl leading-none">
        Beng<span class="text-blue-600">Tix</span>
    </span>
</span>
