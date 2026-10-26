<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('event.lokasi')
            ->latest('order_date')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('detailOrders.tiket.tipeTiket', 'event.lokasi');

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id'         => 'required|exists:events,id',
            'items'            => 'required|array|min:1',
            'items.*.tiket_id' => 'required|integer|exists:tikets,id',
            'items.*.jumlah'   => 'required|integer|min:1|max:10',
        ]);

        $event = Event::findOrFail($data['event_id']);

        if ($event->is_past) {
            throw ValidationException::withMessages([
                'event_id' => 'Event ini sudah berakhir, tiket tidak bisa dibeli lagi.',
            ]);
        }

        // Gabungkan baris dengan tiket_id yang sama agar batas stok tidak bisa dilewati
        $items = collect($data['items'])
            ->groupBy('tiket_id')
            ->map(fn($rows) => (int) $rows->sum('jumlah'));

        $order = DB::transaction(function () use ($event, $items) {
            // Kunci semua baris tiket sekaligus dan pastikan semuanya milik event ini
            $tikets = Tiket::with('tipeTiket')
                ->whereIn('id', $items->keys())
                ->where('event_id', $event->id)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($tikets->count() !== $items->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Ada tiket yang tidak berlaku untuk event ini.',
                ]);
            }

            $total = 0;
            foreach ($items as $tiketId => $jumlah) {
                $tiket = $tikets[$tiketId];

                if ($tiket->stok < $jumlah) {
                    throw ValidationException::withMessages([
                        'items' => "Stok tiket {$tiket->tipeTiket->nama} tersisa {$tiket->stok}.",
                    ]);
                }

                $total += $tiket->harga * $jumlah;
            }

            $order = Order::create([
                'user_id'     => Auth::id(),
                'event_id'    => $event->id,
                'order_date'  => now(),
                'total_harga' => $total,
            ]);

            foreach ($items as $tiketId => $jumlah) {
                $tiket = $tikets[$tiketId];

                DetailOrder::create([
                    'order_id'       => $order->id,
                    'tiket_id'       => $tiket->id,
                    'jumlah'         => $jumlah,
                    'subtotal_harga' => $tiket->harga * $jumlah,
                ]);

                $tiket->decrement('stok', $jumlah);
            }

            return $order;
        });

        session()->flash('success', 'Pesanan berhasil dibuat.');

        return response()->json([
            'ok'       => true,
            'order_id' => $order->id,
            'redirect' => route('orders.show', $order),
        ]);
    }
}
