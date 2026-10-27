<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Menampilkan detail event untuk pengguna.
     */
    public function show(Event $event)
    {
        // Route model binding otomatis tidak menampilkan event
        // yang telah di-soft-delete.
        $event->load([
            'kategori',
            'lokasi',
            'user',
            'tikets' => fn($query) => $query
                ->with('tipeTiket')
                ->orderBy('harga')
                ->orderBy('id'),
        ]);

        return view('events.show', compact('event'));
    }
}
