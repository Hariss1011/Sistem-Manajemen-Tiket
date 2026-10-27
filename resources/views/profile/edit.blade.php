<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <a href="{{ route('home') }}"
                class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600">
                <x-icon name="chevron" class="size-4 rotate-180" />
                Kembali ke beranda
            </a>

            <div class="mt-2 flex items-center gap-4">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <x-icon name="user-round" class="size-6" />
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        Pengaturan profil
                    </h1>
                    <p class="mt-1 text-sm font-normal text-slate-500">
                        Kelola informasi pribadi dan keamanan akun BengTix kamu.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-5xl space-y-7 px-4 sm:px-6 lg:px-8">

            {{-- Ringkasan akun --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-slate-900 px-5 py-6 text-white sm:px-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <div
                            class="flex size-16 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-blue-500/15 text-2xl font-extrabold text-blue-300">
                            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-300">
                                Akun BengTix
                            </p>
                            <h2 class="mt-1 truncate text-xl font-extrabold sm:text-2xl">
                                {{ auth()->user()->name }}
                            </h2>
                            <p class="mt-1 break-all text-sm text-slate-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-slate-300">
                            <span class="size-2 rounded-full bg-emerald-400"></span>
                            Akun aktif
                        </div>
                    </div>
                </div>

                <div class="grid divide-y divide-slate-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                    <div class="flex items-start gap-3 px-5 py-4 sm:px-8">
                        <div
                            class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <x-icon name="user-round" class="size-4" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Informasi pribadi</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Perbarui nama dan alamat email akun.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 px-5 py-4 sm:px-8">
                        <div
                            class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <x-icon name="lock" class="size-4" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Keamanan akun</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Kelola kata sandi dan keamanan akses.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi profil --}}
            <section id="informasi-profil"
                class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-5 sm:px-8 sm:py-6">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <x-icon name="user-round" class="size-5" />
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">
                                Informasi profil
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-slate-500">
                                Pastikan nama dan email kamu selalu benar dan terbaru.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            {{-- Keamanan kata sandi --}}
            <section id="keamanan-akun" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-5 sm:px-8 sm:py-6">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <x-icon name="lock" class="size-5" />
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">
                                Keamanan akun
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-slate-500">
                                Ubah kata sandi secara berkala untuk menjaga keamanan akun.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            {{-- Zona berbahaya --}}
            <section id="hapus-akun" class="overflow-hidden rounded-3xl border border-red-200 bg-white shadow-sm">
                <div class="border-b border-red-100 bg-red-50/70 px-5 py-5 sm:px-8 sm:py-6">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <x-icon name="alert-triangle" class="size-5" />
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-red-800">
                                Zona berbahaya
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-red-700/80">
                                Penghapusan akun merupakan tindakan permanen.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

            <p class="pb-2 text-center text-xs leading-5 text-slate-400">
                Jaga kerahasiaan informasi login kamu dan jangan bagikan kata sandi kepada siapa pun.
            </p>
        </div>
    </div>
</x-app-layout>
