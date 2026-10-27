<section class="space-y-6">
    <header>
        <h3 class="text-base font-extrabold text-slate-900">
            Ubah kata sandi
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
            Gunakan kata sandi yang kuat dan unik untuk membantu melindungi akun BengTix kamu.
        </p>
    </header>

    {{-- Informasi keamanan --}}
    <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50/70 p-4">
        <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
            <x-icon name="lock" class="size-4" />
        </div>
        <div>
            <p class="text-sm font-bold text-blue-900">Tips keamanan</p>
            <p class="mt-1 text-sm leading-6 text-blue-800">
                Buat kata sandi yang panjang, sulit ditebak, dan tidak digunakan pada akun lain.
            </p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Kata sandi saat ini --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata sandi saat ini')"
                class="!text-sm !font-bold !text-slate-700" />

            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-2 block w-full !rounded-xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm !text-slate-900 focus:!border-blue-500 focus:!bg-white focus:!ring-blue-500"
                autocomplete="current-password" placeholder="Masukkan kata sandi saat ini" />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Kata sandi baru --}}
        <div>
            <x-input-label for="update_password_password" :value="__('Kata sandi baru')"
                class="!text-sm !font-bold !text-slate-700" />

            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-2 block w-full !rounded-xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm !text-slate-900 focus:!border-blue-500 focus:!bg-white focus:!ring-blue-500"
                autocomplete="new-password" placeholder="Masukkan kata sandi baru" />

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

            <p class="mt-2 text-xs leading-5 text-slate-400">
                Hindari menggunakan nama, tanggal lahir, atau kombinasi yang mudah ditebak.
            </p>
        </div>

        {{-- Konfirmasi kata sandi --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi kata sandi baru')"
                class="!text-sm !font-bold !text-slate-700" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-2 block w-full !rounded-xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm !text-slate-900 focus:!border-blue-500 focus:!bg-white focus:!ring-blue-500"
                autocomplete="new-password" placeholder="Ulangi kata sandi baru" />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Aksi --}}
        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center">
            <x-primary-button
                class="!inline-flex !min-h-11 !items-center !justify-center !rounded-xl !bg-blue-600 !px-5 !py-3 !text-sm !font-bold !text-white !shadow-sm transition hover:!bg-blue-700 focus:!ring-blue-500">
                <x-icon name="lock" class="mr-2 size-4" />
                Simpan kata sandi
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition.opacity x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700">
                    <x-icon name="check-circle" class="size-4" />
                    Kata sandi berhasil diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>
