<section class="space-y-6">
    <header>
        <h3 class="text-base font-extrabold text-slate-900">
            Data pribadi
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
            Informasi ini digunakan untuk mengidentifikasi akun kamu di BengTix.
            Pastikan alamat email yang digunakan masih aktif.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama lengkap')" class="text-sm! font-bold! text-slate-700!" />

            <x-text-input id="name" name="name" type="text"
                class="mt-2 block w-full rounded-xl! border-slate-200! bg-slate-50! px-4! py-3! text-sm! text-slate-900! placeholder:text-slate-400! focus:border-blue-500! focus:bg-white! focus:ring-blue-500!"
                :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Alamat email')" class="text-sm! font-bold! text-slate-700!" />

            <x-text-input id="email" name="email" type="email"
                class="mt-2 block w-full rounded-xl! border-slate-200! bg-slate-50! px-4! py-3! text-sm! text-slate-900! placeholder:text-slate-400! focus:border-blue-500! focus:bg-white! focus:ring-blue-500!"
                :value="old('email', $user->email)" required autocomplete="username" placeholder="nama@email.com" />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Status verifikasi email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                            <x-icon name="alert-triangle" class="size-4" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-amber-900">
                                Email belum diverifikasi
                            </p>
                            <p class="mt-1 text-sm leading-6 text-amber-800">
                                Verifikasi email untuk membantu memastikan bahwa alamat email ini benar-benar milik
                                kamu.
                            </p>

                            <button form="send-verification" type="submit"
                                class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-amber-900 underline decoration-amber-400 underline-offset-4 transition hover:text-amber-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2">
                                Kirim ulang email verifikasi
                                <x-icon name="chevron" class="size-4" />
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 rounded-lg bg-white/70 px-3 py-2 text-sm font-semibold text-emerald-700">
                            Email verifikasi baru berhasil dikirim. Periksa kotak masuk kamu.
                        </p>
                    @endif
                </div>
            @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
                <div
                    class="mt-3 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                    <x-icon name="check-circle" class="size-4" />
                    Email sudah terverifikasi
                </div>
            @endif
        </div>

        {{-- Tombol simpan --}}
        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center">
            <x-primary-button
                class="inline-flex! min-h-11! items-center! justify-center! rounded-xl! bg-blue-600! px-5! py-3! text-sm! font-bold! text-white! shadow-sm! transition! hover:bg-blue-700! focus:ring-blue-500!">
                Simpan perubahan
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition.opacity x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700">
                    <x-icon name="check-circle" class="size-4" />
                    Perubahan profil berhasil disimpan.
                </p>
            @endif
        </div>
    </form>
</section>
