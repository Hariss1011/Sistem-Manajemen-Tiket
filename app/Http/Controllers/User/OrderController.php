<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pengguna yang login.
     */
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('event.lokasi')
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan.
     * Pengguna hanya boleh melihat pesanan miliknya sendiri.
     */
    public function show(Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) Auth::id(),
            403
        );

        $order->load([
            'event.lokasi',
            'detailOrders.tiket.tipeTiket',
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Memvalidasi dan menyimpan pesanan tiket.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => [
                'required',
                'integer',
                'exists:events,id',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
                'max:50',
            ],
            'items.*.tiket_id' => [
                'required',
                'integer',
                'distinct',
                'exists:tikets,id',
            ],
            'items.*.jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],
        ], [
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists' => 'Event tidak ditemukan.',
            'items.required' => 'Pilih setidaknya satu tiket.',
            'items.min' => 'Pilih setidaknya satu tiket.',
            'items.max' => 'Jumlah jenis tiket dalam satu pesanan terlalu banyak.',
            'items.*.tiket_id.required' => 'Jenis tiket wajib dipilih.',
            'items.*.tiket_id.distinct' => 'Jenis tiket yang sama tidak boleh dikirim berulang kali.',
            'items.*.tiket_id.exists' => 'Tiket yang dipilih tidak ditemukan.',
            'items.*.jumlah.required' => 'Jumlah tiket wajib diisi.',
            'items.*.jumlah.integer' => 'Jumlah tiket harus berupa bilangan bulat.',
            'items.*.jumlah.min' => 'Jumlah tiket minimal satu.',
            'items.*.jumlah.max' => 'Maksimal 10 tiket per jenis dalam satu pesanan.',
        ]);

        $userId = Auth::id();

        // Hitung dan gabungkan jumlah per tiket untuk pemeriksaan stok.
        $items = collect($data['items'])
            ->groupBy('tiket_id')
            ->map(
                fn($rows) => (int) $rows->sum('jumlah')
            );

        foreach ($items as $jumlah) {
            if ($jumlah > 10) {
                throw ValidationException::withMessages([
                    'items' => 'Maksimal 10 tiket untuk setiap jenis tiket dalam satu pesanan.',
                ]);
            }
        }

        $order = DB::transaction(function () use (
            $data,
            $items,
            $userId
        ) {
            // Kunci event agar proses pemesanan untuk event yang sama
            // tidak memeriksa status event secara bersamaan.
            $event = Event::query()
                ->whereKey($data['event_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($event->is_past) {
                throw ValidationException::withMessages([
                    'event_id' => 'Event ini sudah berakhir. Tiket tidak bisa dibeli lagi.',
                ]);
            }

            // Kunci tiket dan ambil hanya tiket milik event tersebut.
            $tikets = Tiket::query()
                ->with('tipeTiket')
                ->where('event_id', $event->id)
                ->whereIn('id', $items->keys())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($tikets->count() !== $items->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Ada tiket yang tidak berlaku untuk event ini.',
                ]);
            }

            $totalCents = 0;
            $rincian = [];

            // Validasi stok dan hitung harga menggunakan satuan sen
            // untuk menghindari akumulasi pecahan floating point.
            foreach ($items as $tiketId => $jumlah) {
                $tiket = $tikets->get($tiketId);

                if (! $tiket) {
                    throw ValidationException::withMessages([
                        'items' => 'Tiket yang dipilih tidak ditemukan.',
                    ]);
                }

                if ($tiket->stok < $jumlah) {
                    $namaTipe = $tiket->tipeTiket?->nama
                        ?? 'Tiket';

                    throw ValidationException::withMessages([
                        'items' => "Stok {$namaTipe} tidak mencukupi. Stok tersedia: {$tiket->stok}.",
                    ]);
                }

                $hargaCents = $this->hargaKeCents(
                    $tiket->harga
                );

                $subtotalCents = $hargaCents * $jumlah;
                $totalCents += $subtotalCents;

                $rincian[] = [
                    'tiket' => $tiket,
                    'jumlah' => $jumlah,
                    'subtotal_cents' => $subtotalCents,
                ];
            }

            // Kolom decimal(10, 2) maksimal 99.999.999,99.
            if ($totalCents > 9_999_999_999) {
                throw ValidationException::withMessages([
                    'items' => 'Total pesanan melebihi batas nilai transaksi.',
                ]);
            }

            $order = Order::create([
                'user_id' => $userId,
                'event_id' => $event->id,
                'order_date' => now(),
                'total_harga' => $this->centsKeHarga($totalCents),
            ]);

            foreach ($rincian as $item) {
                $tiket = $item['tiket'];
                $jumlah = $item['jumlah'];

                $tiket->detailOrders()->create([
                    'order_id' => $order->id,
                    'jumlah' => $jumlah,
                    'subtotal_harga' => $this->centsKeHarga(
                        $item['subtotal_cents']
                    ),
                ]);

                // Pengurangan stok terjadi dalam transaksi yang sama.
                $tiket->decrement('stok', $jumlah);
            }

            return $order;
        }, 3);

        return response()->json([
            'ok' => true,
            'order_id' => $order->id,
            'redirect' => route('orders.show', $order),
        ]);
    }

    /**
     * Mengubah harga decimal menjadi bilangan bulat dalam satuan sen.
     */
    private function hargaKeCents(string|int|float $harga): int
    {
        $formatted = number_format(
            (float) $harga,
            2,
            '.',
            ''
        );

        [$rupiah, $sen] = array_pad(
            explode('.', $formatted, 2),
            2,
            '00'
        );

        return ((int) $rupiah * 100) + (int) $sen;
    }

    /**
     * Mengubah bilangan bulat dalam satuan sen menjadi string decimal.
     */
    private function centsKeHarga(int $cents): string
    {
        return intdiv($cents, 100)
            . '.'
            . str_pad(
                (string) ($cents % 100),
                2,
                '0',
                STR_PAD_LEFT
            );
    }
}
