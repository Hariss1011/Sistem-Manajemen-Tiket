<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\TipeTiket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TiketController extends Controller
{
    /**
     * Menampilkan daftar event sebagai pintu masuk pengelolaan tiket.
     * Pengelolaan tiket saat ini dilakukan melalui halaman detail event.
     */
    public function index()
    {
        return redirect()
            ->route('admin.events.index')
            ->with('info', 'Pilih event untuk mengelola tiketnya.');
    }

    /**
     * Form tiket tersedia dalam modal di halaman detail event.
     */
    public function create()
    {
        return redirect()->route('admin.events.index');
    }

    /**
     * Menyimpan tiket baru untuk suatu event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => [
                'required',
                'integer',
                'exists:events,id',
            ],
            'tipe_tiket_id' => [
                'required',
                'integer',
                'exists:tipe_tikets,id',
            ],
            'harga' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'stok' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
        ], [
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists' => 'Event yang dipilih tidak ditemukan.',
            'tipe_tiket_id.required' => 'Tipe tiket wajib dipilih.',
            'tipe_tiket_id.exists' => 'Tipe tiket yang dipilih tidak ditemukan.',
            'harga.required' => 'Harga tiket wajib diisi.',
            'harga.numeric' => 'Harga tiket harus berupa angka.',
            'harga.min' => 'Harga tiket tidak boleh negatif.',
            'stok.required' => 'Stok tiket wajib diisi.',
            'stok.integer' => 'Stok tiket harus berupa bilangan bulat.',
            'stok.min' => 'Stok tiket tidak boleh negatif.',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        // Pastikan tipe tiket belum digunakan pada event yang sama.
        $tipeSudahAda = Tiket::where('event_id', $event->id)
            ->where('tipe_tiket_id', $validated['tipe_tiket_id'])
            ->exists();

        if ($tipeSudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'tipe_tiket_id' =>
                    'Tipe tiket tersebut sudah tersedia pada event ini.',
                ]);
        }

        Tiket::create($validated);

        return redirect()
            ->route('admin.events.show', $event->id)
            ->with('success', 'Tiket berhasil ditambahkan.');
    }

    /**
     * Detail tiket ditampilkan melalui halaman detail event.
     */
    public function show(string $id)
    {
        $tiket = Tiket::findOrFail($id);

        return redirect()->route('admin.events.show', $tiket->event_id);
    }

    /**
     * Form edit tiket menggunakan modal pada halaman detail event.
     */
    public function edit(string $id)
    {
        $tiket = Tiket::findOrFail($id);

        return redirect()->route('admin.events.show', $tiket->event_id);
    }

    /**
     * Memperbarui tipe, harga, dan stok tiket.
     */
    public function update(Request $request, string $id)
    {
        $tiket = Tiket::findOrFail($id);

        $validated = $request->validate([
            'tipe_tiket_id' => [
                'required',
                'integer',
                'exists:tipe_tikets,id',
                Rule::unique('tikets', 'tipe_tiket_id')
                    ->where('event_id', $tiket->event_id)
                    ->ignore($tiket->id),
            ],
            'harga' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'stok' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
        ], [
            'tipe_tiket_id.required' => 'Tipe tiket wajib dipilih.',
            'tipe_tiket_id.exists' => 'Tipe tiket tidak ditemukan.',
            'tipe_tiket_id.unique' =>
            'Tipe tiket tersebut sudah tersedia pada event ini.',
            'harga.required' => 'Harga tiket wajib diisi.',
            'harga.numeric' => 'Harga tiket harus berupa angka.',
            'harga.min' => 'Harga tiket tidak boleh negatif.',
            'stok.required' => 'Stok tiket wajib diisi.',
            'stok.integer' => 'Stok tiket harus berupa bilangan bulat.',
            'stok.min' => 'Stok tiket tidak boleh negatif.',
        ]);

        // Stok tidak boleh dikurangi di bawah jumlah tiket yang sudah terjual.
        $jumlahTerjual = (int) $tiket->detailOrders()->sum('jumlah');

        if ($validated['stok'] < $jumlahTerjual) {
            return back()
                ->withInput()
                ->withErrors([
                    'stok' => "Stok tidak boleh kurang dari jumlah tiket yang sudah tercatat terjual ({$jumlahTerjual}).",
                ]);
        }

        $tiket->update($validated);

        return redirect()
            ->route('admin.events.show', $tiket->event_id)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    /**
     * Menghapus tiket yang belum memiliki riwayat transaksi.
     */
    public function destroy(string $id)
    {
        $tiket = Tiket::findOrFail($id);

        if ($tiket->detailOrders()->exists()) {
            return redirect()
                ->route('admin.events.show', $tiket->event_id)
                ->with('error', 'Tiket tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        $eventId = $tiket->event_id;

        $tiket->delete();

        return redirect()
            ->route('admin.events.show', $eventId)
            ->with('success', 'Tiket berhasil dihapus.');
    }
}
