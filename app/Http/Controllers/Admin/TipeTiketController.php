<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipeTiket;

class TipeTiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipeTikets = TipeTiket::all();
        return view('admin.tipe_tiket.index', compact('tipeTikets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_tikets,nama',
        ]);

        TipeTiket::create($validatedData);

        return redirect()->route('admin.tipe_tiket.index')->with('success', 'Tipe tiket berhasil ditambahkan.');
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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $payload = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        if (!isset($payload['nama'])) {
            return redirect()->route('admin.tipe_tiket.index')->with('error', 'Nama tipe tiket wajib diisi.');
        }

        $tipeTikets = TipeTiket::findOrFail($id);
        $tipeTikets->nama = $payload['nama'];
        $tipeTikets->save();

        return redirect()->route('admin.tipe_tiket.index')->with('success', 'Tipe Tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipeTikets = TipeTiket::findOrFail($id);
        $tipeTikets->delete();

        return redirect()->route('admin.tipe_tiket.index')->with('success', 'Tipe tiket berhasil dihapus.');
    }
}
