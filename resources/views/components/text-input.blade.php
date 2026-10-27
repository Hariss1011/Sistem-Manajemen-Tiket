@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'input w-full rounded-xl border border-slate-200 bg-white text-slate-800 placeholder:text-slate-400 shadow-sm transition duration-200 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500 disabled:opacity-80',
    ]) }}>
