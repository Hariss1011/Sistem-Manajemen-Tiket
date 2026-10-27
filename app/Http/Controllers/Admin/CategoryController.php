<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Kategori::query()
            ->withCount('events')
            ->orderBy('nama')
            ->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Form kategori menggunakan modal pada halaman index.
     */
    public function create()
    {
        return redirect()->route('admin.categories.index');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:kategoris,nama',
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
            'nama.unique' => 'Nama kategori tersebut sudah digunakan.',
        ]);

        $validated['nama'] = trim($validated['nama']);

        Kategori::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Detail kategori ditampilkan melalui halaman index.
     */
    public function show(string $id)
    {
        Kategori::findOrFail($id);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Form edit kategori menggunakan modal pada halaman index.
     */
    public function edit(string $id)
    {
        Kategori::findOrFail($id);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Memperbarui kategori.
     */
    public function update(Request $request, string $id)
    {
        $category = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategoris', 'nama')
                    ->ignore($category->id),
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
            'nama.unique' => 'Nama kategori tersebut sudah digunakan.',
        ]);

        $validated['nama'] = trim($validated['nama']);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori jika belum digunakan oleh event.
     */
    public function destroy(string $id)
    {
        $category = Kategori::findOrFail($id);

        if ($category->events()->withTrashed()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan oleh event.'
                );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
