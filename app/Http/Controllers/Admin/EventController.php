<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\TipeTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class EventController extends Controller
{
    /**
     * Menampilkan daftar event.
     */
    public function index()
    {
        $events = Event::query()
            ->with(['kategori', 'lokasi'])
            ->latest()
            ->paginate(10);

        return view('admin.event.index', compact('events'));
    }

    /**
     * Menampilkan form tambah event.
     */
    public function create()
    {
        $categories = Kategori::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        return view('admin.event.create', compact(
            'categories',
            'lokasis'
        ));
    }

    /**
     * Menyimpan event baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],
            'deskripsi' => [
                'required',
                'string',
                'max:10000',
            ],
            'tanggal_waktu' => [
                'required',
                'date',
            ],
            'lokasi_id' => [
                'required',
                'integer',
                'exists:lokasis,id',
            ],
            'kategori_id' => [
                'required',
                'integer',
                'exists:kategoris,id',
            ],
            'gambar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'judul.required' => 'Judul event wajib diisi.',
            'judul.max' => 'Judul event maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi event wajib diisi.',
            'deskripsi.max' => 'Deskripsi event maksimal 10.000 karakter.',
            'tanggal_waktu.required' => 'Tanggal dan waktu event wajib diisi.',
            'tanggal_waktu.date' => 'Tanggal dan waktu event tidak valid.',
            'lokasi_id.required' => 'Lokasi event wajib dipilih.',
            'lokasi_id.exists' => 'Lokasi yang dipilih tidak ditemukan.',
            'kategori_id.required' => 'Kategori event wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'gambar.required' => 'Gambar event wajib diunggah.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $validated['judul'] = trim($validated['judul']);

        $gambar = $request->file('gambar');
        $namaGambar = $this->simpanGambar($gambar);

        $validated['gambar'] = $namaGambar;
        $validated['user_id'] = $request->user()->id;

        try {
            Event::create($validated);
        } catch (Throwable $exception) {
            // Hapus file baru jika penyimpanan event gagal.
            $path = public_path('images/events/' . $namaGambar);

            if (File::exists($path)) {
                File::delete($path);
            }

            report($exception);

            return back()
                ->withInput($request->except('gambar'))
                ->with(
                    'error',
                    'Event gagal disimpan. Silakan periksa data dan coba kembali.'
                );
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail event dan tiketnya.
     */
    public function show(string $id)
    {
        $event = Event::with([
            'tikets.tipeTiket',
            'kategori',
            'lokasi',
            'user',
        ])->findOrFail($id);

        // Variabel berikut diperlukan oleh halaman detail event saat ini.
        $tickets = $event->tikets;
        $tipeTikets = TipeTiket::orderBy('nama')->get();
        $categories = Kategori::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        return view('admin.event.show', compact(
            'event',
            'tickets',
            'tipeTikets',
            'categories',
            'lokasis'
        ));
    }

    /**
     * Menampilkan form edit event.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $categories = Kategori::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        return view('admin.event.edit', compact(
            'event',
            'categories',
            'lokasis'
        ));
    }

    /**
     * Memperbarui event.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],
            'deskripsi' => [
                'required',
                'string',
                'max:10000',
            ],
            'tanggal_waktu' => [
                'required',
                'date',
            ],
            'lokasi_id' => [
                'required',
                'integer',
                'exists:lokasis,id',
            ],
            'kategori_id' => [
                'required',
                'integer',
                'exists:kategoris,id',
            ],
            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'judul.required' => 'Judul event wajib diisi.',
            'judul.max' => 'Judul event maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi event wajib diisi.',
            'deskripsi.max' => 'Deskripsi event maksimal 10.000 karakter.',
            'tanggal_waktu.required' => 'Tanggal dan waktu event wajib diisi.',
            'tanggal_waktu.date' => 'Tanggal dan waktu event tidak valid.',
            'lokasi_id.required' => 'Lokasi event wajib dipilih.',
            'lokasi_id.exists' => 'Lokasi yang dipilih tidak ditemukan.',
            'kategori_id.required' => 'Kategori event wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak ditemukan.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $validated['judul'] = trim($validated['judul']);

        $namaGambarBaru = null;

        if ($request->hasFile('gambar')) {
            $namaGambarBaru = $this->simpanGambar(
                $request->file('gambar')
            );

            $validated['gambar'] = $namaGambarBaru;
        } else {
            // Jangan menimpa gambar lama jika pengguna tidak menggantinya.
            unset($validated['gambar']);
        }

        $gambarLama = $event->gambar;

        try {
            $event->update($validated);
        } catch (Throwable $exception) {
            if ($namaGambarBaru !== null) {
                $path = public_path('images/events/' . $namaGambarBaru);

                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            report($exception);

            return back()
                ->withInput($request->except('gambar'))
                ->with(
                    'error',
                    'Event gagal diperbarui. Silakan coba kembali.'
                );
        }

        // Hapus gambar lama hanya setelah perubahan database berhasil.
        if (
            $namaGambarBaru !== null
            && $gambarLama
            && ! Str::startsWith($gambarLama, ['http://', 'https://'])
            && basename($gambarLama) === $gambarLama
        ) {
            $pathLama = public_path('images/events/' . $gambarLama);

            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Menghapus event secara soft delete.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        // Model Event menggunakan SoftDeletes.
        // Gambar dipertahankan agar riwayat pesanan tetap dapat ditampilkan.
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    /**
     * Menyimpan gambar event ke public/images/events.
     */
    private function simpanGambar($gambar): string
    {
        $direktori = public_path('images/events');

        File::ensureDirectoryExists($direktori);

        $namaFile = Str::uuid() . '.' . $gambar->extension();

        $gambar->move($direktori, $namaFile);

        return $namaFile;
    }
}
