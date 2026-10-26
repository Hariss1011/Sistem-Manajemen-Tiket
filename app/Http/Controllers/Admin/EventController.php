<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\TipeTiket;
use App\Models\Lokasi;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //get
    public function index()
    {
        $events = Event::all();
        $events = Event::with(['kategori', 'lokasi'])->latest()->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Kategori::all();
        $lokasis = Lokasi::all();
        return view('admin.event.create', compact('categories', 'lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_waktu' => 'required|date',
            'lokasi_id' => 'required|exists:lokasis,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $imageName = \Illuminate\Support\Str::uuid() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/events'), $imageName);
            $validatedData['gambar'] = $imageName;
        }

        $validatedData['user_id'] = auth()->user()->id;

        Event::create($validatedData);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['tikets.tipeTiket', 'kategori', 'lokasi', 'user']);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $categories = Kategori::all();
        $lokasis = Lokasi::all();
        return view('admin.event.edit', compact('event', 'categories', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $validatedData = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal_waktu' => 'required|date',
                'lokasi_id' => 'required|exists:lokasis,id',
                'kategori_id' => 'required|exists:kategoris,id',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $imageName = \Illuminate\Support\Str::uuid() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('images/events'), $imageName);
                $validatedData['gambar'] = $imageName;
            }

            $event->update($validatedData);

            return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui event: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
