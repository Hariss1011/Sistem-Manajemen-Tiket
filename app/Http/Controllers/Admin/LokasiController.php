<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LokasiController extends Controller
{
    /**
     * Menampilkan daftar lokasi.
     */
    public function index()
    {
        $Lokasis = Lokasi::query()
            ->withCount('events')
            ->orderBy('nama_lokasi')
            ->get();

        return view('admin.lokasi.index', compact('Lokasis'));
    }

    /**
     * Menampilkan form tambah lokasi.
     */
    public function create()
    {
        return view('admin.lokasi.create');
    }

    /**
     * Menyimpan lokasi baru.
     */
    public function store(Request $request)
    {
        $request->merge([
            'nama_lokasi' => trim(
                (string) $request->input('nama_lokasi')
            ),
        ]);

        $validated = $request->validate([
            'nama_lokasi' => [
                'required',
                'string',
                'max:255',
                'unique:lokasis,nama_lokasi',
            ],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.string' => 'Nama lokasi harus berupa teks.',
            'nama_lokasi.max' => 'Nama lokasi maksimal 255 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi tersebut sudah digunakan.',
        ]);

        Lokasi::create($validated);

        return redirect()
            ->route('admin.lokasis.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Detail lokasi saat ini diakses melalui halaman index.
     */
    public function show(string $id)
    {
        Lokasi::findOrFail($id);

        return redirect()->route('admin.lokasis.index');
    }

    /**
     * Menampilkan form edit lokasi.
     */
    public function edit(string $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view('admin.lokasi.edit', compact('lokasi'));
    }

    /**
     * Memperbarui lokasi.
     */
    public function update(Request $request, string $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->merge([
            'nama_lokasi' => trim(
                (string) $request->input('nama_lokasi')
            ),
        ]);

        $validated = $request->validate([
            'nama_lokasi' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lokasis', 'nama_lokasi')
                    ->ignore($lokasi->id),
            ],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.string' => 'Nama lokasi harus berupa teks.',
            'nama_lokasi.max' => 'Nama lokasi maksimal 255 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi tersebut sudah digunakan.',
        ]);

        $lokasi->update($validated);

        return redirect()
            ->route('admin.lokasis.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Menghapus lokasi jika tidak digunakan oleh event.
     */
    public function destroy(string $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        if ($lokasi->events()->withTrashed()->exists()) {
            return redirect()
                ->route('admin.lokasis.index')
                ->with(
                    'error',
                    'Lokasi tidak dapat dihapus karena masih digunakan oleh event.'
                );
        }

        $lokasi->delete();

        return redirect()
            ->route('admin.lokasis.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
