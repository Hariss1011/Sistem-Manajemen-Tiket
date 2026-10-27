<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan beranda dan daftar event.
     */
    public function index(Request $request)
    {
        // Batasi panjang kata kunci agar pencarian tetap wajar.
        $q = mb_substr(
            trim((string) $request->query('q', '')),
            0,
            100
        );

        $selesai = $request->query('status') === 'selesai';

        $urut = in_array(
            $request->query('urut'),
            ['termurah', 'terbaru', 'terdekat'],
            true
        )
            ? $request->query('urut')
            : 'terdekat';

        // Hanya gunakan ID filter yang valid.
        $kategoriId = filter_var(
            $request->query('kategori'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        $lokasiId = filter_var(
            $request->query('lokasi'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        $query = Event::query()
            ->with(['kategori', 'lokasi'])
            ->withMin('tikets', 'harga')
            ->search($q)
            ->when(
                $kategoriId !== false && $kategoriId !== null,
                fn($builder) => $builder->where(
                    'kategori_id',
                    $kategoriId
                )
            )
            ->when(
                $lokasiId !== false && $lokasiId !== null,
                fn($builder) => $builder->where(
                    'lokasi_id',
                    $lokasiId
                )
            );

        // Pisahkan event yang sudah selesai dan yang akan datang.
        if ($selesai) {
            $query->where('tanggal_waktu', '<', now());
        } else {
            $query->upcoming();
        }

        // Terapkan pengurutan yang dipilih pengguna.
        switch ($urut) {
            case 'termurah':
                $query
                    ->orderByRaw(
                        'CASE WHEN tikets_min_harga IS NULL THEN 1 ELSE 0 END'
                    )
                    ->orderBy('tikets_min_harga')
                    ->orderBy(
                        'tanggal_waktu',
                        $selesai ? 'desc' : 'asc'
                    )
                    ->orderBy('id');
                break;

            case 'terbaru':
                $query
                    ->orderByDesc('created_at')
                    ->orderByDesc('id');
                break;

            default:
                $query
                    ->orderBy(
                        'tanggal_waktu',
                        $selesai ? 'desc' : 'asc'
                    )
                    ->orderBy('id');
                break;
        }

        $events = $query
            ->paginate(9)
            ->withQueryString();

        // Event unggulan tidak terpengaruh filter pencarian.
        $featured = Event::query()
            ->upcoming()
            ->with(['kategori', 'lokasi'])
            ->withMin('tikets', 'harga')
            ->orderBy('tanggal_waktu')
            ->orderBy('id')
            ->first();

        return view('home', [
            'events' => $events,
            'featured' => $featured,
            'categories' => Kategori::query()
                ->orderBy('nama')
                ->get(),
            'lokasis' => Lokasi::query()
                ->orderBy('nama_lokasi')
                ->get(),
            'totalUpcoming' => Event::upcoming()->count(),
            'q' => $q,
            'selesai' => $selesai,
            'urut' => $urut,
        ]);
    }
}
