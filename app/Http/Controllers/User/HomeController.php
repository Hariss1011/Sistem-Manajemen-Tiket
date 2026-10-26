<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $selesai = $request->query('status') === 'selesai';
        $urut = in_array($request->query('urut'), ['termurah', 'terbaru'], true) ? $request->query('urut') : 'terdekat';

        $query = Event::query()
            ->with(['kategori', 'lokasi'])
            ->withMin('tikets', 'harga')
            ->withSum('tikets', 'stok')
            ->withCount('tikets')
            ->search($q)
            ->when($request->filled('kategori'), fn($x) => $x->where('kategori_id', $request->integer('kategori')))
            ->when($request->filled('lokasi'), fn($x) => $x->where('lokasi_id', $request->integer('lokasi')));

        $selesai
            ? $query->where('tanggal_waktu', '<', now())
            : $query->upcoming();

        match ($urut) {
            'termurah' => $query->orderByRaw('tikets_min_harga is null')->orderBy('tikets_min_harga')->orderBy('tanggal_waktu'),
            'terbaru' => $query->latest(),
            default => $query->orderBy('tanggal_waktu', $selesai ? 'desc' : 'asc'),
        };

        $events = $query->paginate(9)->withQueryString();

        // Event terdekat untuk hero (tidak terpengaruh filter)
        $featured = Event::upcoming()
            ->with(['kategori', 'lokasi'])
            ->withMin('tikets', 'harga')
            ->orderBy('tanggal_waktu')
            ->first();

        return view('home', [
            'events' => $events,
            'featured' => $featured,
            'categories' => Kategori::orderBy('nama')->get(),
            'lokasis' => Lokasi::orderBy('nama_lokasi')->get(),
            'totalUpcoming' => Event::upcoming()->count(),
            'q' => $q,
            'selesai' => $selesai,
            'urut' => $urut,
        ]);
    }
}
