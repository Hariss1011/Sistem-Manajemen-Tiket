<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeTiket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipeTiketController extends Controller
{
    /**
     * Menampilkan daftar tipe tiket.
     */
    public function index()
    {
        $tipeTikets = TipeTiket::query()
            ->withCount('tikets')
            ->orderBy('nama')
            ->get();

        return view('admin.tipe_tiket.index', compact('tipeTikets'));
    }

    /**
     * Form tambah tipe tiket menggunakan modal pada halaman index.
     */
    public function create()
    {
        return redirect()->route('admin.tipe_tiket.index');
    }

    /**
     * Menyimpan tipe tiket baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:tipe_tikets,nama',
            ],
        ], [
            'nama.required' => 'Nama tipe tiket wajib diisi.',
            'nama.string' => 'Nama tipe tiket harus berupa teks.',
            'nama.max' => 'Nama tipe tiket maksimal 255 karakter.',
            'nama.unique' => 'Nama tipe tiket tersebut sudah digunakan.',
        ]);

        TipeTiket::create($validated);

        return redirect()
            ->route('admin.tipe_tiket.index')
            ->with('success', 'Tipe tiket berhasil ditambahkan.');
    }

    /**
     * Detail tipe tiket saat ini ditampilkan melalui halaman index.
     */
    public function show(string $id)
    {
        TipeTiket::findOrFail($id);

        return redirect()->route('admin.tipe_tiket.index');
    }

    /**
     * Form edit tipe tiket menggunakan modal pada halaman index.
     */
    public function edit(string $id)
    {
        TipeTiket::findOrFail($id);

        return redirect()->route('admin.tipe_tiket.index');
    }

    /**
     * Memperbarui nama tipe tiket.
     */
    public function update(Request $request, string $id)
    {
        $tipeTiket = TipeTiket::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tipe_tikets', 'nama')
                    ->ignore($tipeTiket->id),
            ],
        ], [
            'nama.required' => 'Nama tipe tiket wajib diisi.',
            'nama.string' => 'Nama tipe tiket harus berupa teks.',
            'nama.max' => 'Nama tipe tiket maksimal 255 karakter.',
            'nama.unique' => 'Nama tipe tiket tersebut sudah digunakan.',
        ]);

        $tipeTiket->update($validated);

        return redirect()
            ->route('admin.tipe_tiket.index')
            ->with('success', 'Tipe tiket berhasil diperbarui.');
    }

    /**
     * Menghapus tipe tiket yang belum digunakan oleh tiket mana pun.
     */
    public function destroy(string $id)
    {
        $tipeTiket = TipeTiket::findOrFail($id);

        if ($tipeTiket->tikets()->exists()) {
            return redirect()
                ->route('admin.tipe_tiket.index')
                ->with('error', 'Tipe tiket tidak dapat dihapus karena masih digunakan oleh satu atau lebih tiket.');
        }

        $tipeTiket->delete();

        return redirect()
            ->route('admin.tipe_tiket.index')
            ->with('success', 'Tipe tiket berhasil dihapus.');
    }
}
