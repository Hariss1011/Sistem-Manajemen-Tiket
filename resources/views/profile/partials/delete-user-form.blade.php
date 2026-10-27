<section class="space-y-6">
    <header>
        <h3 class="text-base font-extrabold text-slate-900">
            Hapus akun BengTix
        </h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
            Jika kamu tidak ingin menggunakan akun ini lagi, kamu dapat menghapusnya secara permanen.
            Tindakan ini tidak dapat dibatalkan.
        </p>
    </header>

    {{-- Peringatan --}}
    <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
        <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-700">
            <x-icon name="alert-triangle" class="size-4" />
        </div>

        <div>
            <p class="text-sm font-bold text-red-900">
                Perhatian: penghapusan permanen
            </p>
            <p class="mt-1 text-sm leading-6 text-red-800">
                Data akun dan informasi terkait dapat terhapus secara permanen. Pastikan kamu telah mempertimbangkan
                keputusan ini sebelum melanjutkan.
            </p>
        </div>
    </div>

    <div class="flex flex-col gap-4 border-t border-red-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold text-slate-800">
                Yakin ingin menghapus akun?
            </p>
            <p class="mt-1 text-sm leading-6 text-slate-500">
                Kamu akan diminta memasukkan kata sandi untuk mengonfirmasi tindakan ini.
            </p>
        </div>

        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="!inline-flex !min-h-11 !shrink-0 !items-center !justify-center !rounded-xl !bg-red-600 !px-5 !py-3 !text-sm !font-bold !text-white transition hover:!bg-red-700 focus:!ring-red-500">
            <x-icon name="trash-2" class="mr-2 size-4" />
            Hapus akun
        </x-danger-button>
    </div>

    {{-- Modal konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-5 sm:p-7">
            @csrf
            @method('delete')

            <div class="flex items-start gap-4">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                    <x-icon name="alert-triangle" class="size-6" />
                </div>

                <div class="min-w-0">
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-900">
                        Konfirmasi penghapusan akun
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Apakah kamu yakin ingin menghapus akun secara permanen? Seluruh data yang terkait dapat hilang
                        dan tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm font-semibold leading-6 text-red-800">
                    Untuk melanjutkan, masukkan kata sandi akun kamu sebagai verifikasi keamanan.
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" :value="__('Kata sandi')" class="!text-sm !font-bold !text-slate-700" />

                <x-text-input id="password" name="password" type="password"
                    class="mt-2 block w-full !rounded-xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm focus:!border-red-500 focus:!bg-white focus:!ring-red-500"
                    placeholder="Masukkan kata sandi untuk konfirmasi" autocomplete="current-password" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="!inline-flex !min-h-11 !items-center !justify-center !rounded-xl !border-slate-200 !px-5 !py-3 !text-sm !font-bold !text-slate-700 transition hover:!bg-slate-100">
                    Batal
                </x-secondary-button>

                <x-danger-button
                    class="!inline-flex !min-h-11 !items-center !justify-center !rounded-xl !bg-red-600 !px-5 !py-3 !text-sm !font-bold !text-white transition hover:!bg-red-700 focus:!ring-red-500">
                    <x-icon name="trash-2" class="mr-2 size-4" />
                    Ya, hapus akun saya
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
