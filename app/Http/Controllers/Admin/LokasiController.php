<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Lokasis = Lokasi::all();
        return view('admin.lokasi.index', compact('Lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama_lokasi'])) {
            return redirect()->route('lokasi.index')->with('error', 'Nama lokasi wajib diisi.');
        }

        Lokasi::create([
            'nama_lokasi' => $payload['nama_lokasi'],
        ]);

        return redirect()->route('admin.lokasis.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama_lokasi'])) {
            return redirect()->route('lokasis.index')->with('error', 'Nama lokasi wajib diisi.');
        }

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update([
            'nama_lokasi' => $payload['nama_lokasi'],
        ]);

        return redirect()->route('admin.lokasis.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasis = Lokasi::findOrFail($id);
        $lokasis->delete();

        return redirect()->route('admin.lokasis.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
