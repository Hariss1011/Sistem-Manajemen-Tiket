<?php

namespace Database\Seeders;

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->firstOrFail();

        // [judul event, hari lalu, [[urutan tiket di event, jumlah], ...]]
        $pesanan = [
            ['Konser Reuni Band Kampus', 25, [[0, 2]]],
            ['Malam Rock Nusantara', 6, [[0, 1], [1, 2]]],
            ['Workshop Laravel dari Nol sampai Deploy', 3, [[0, 1]]],
        ];

        foreach ($pesanan as [$judul, $hariLalu, $baris]) {
            $event = Event::where('judul', $judul)->firstOrFail();
            $tikets = $event->tikets()->orderBy('id')->get();

            $order = Order::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'order_date' => now()->subDays($hariLalu),
                'total_harga' => 0,
            ]);

            $total = 0;
            foreach ($baris as [$urutan, $jumlah]) {
                $tiket = $tikets[$urutan];
                $subtotal = $tiket->harga * $jumlah;
                $total += $subtotal;

                DetailOrder::create([
                    'order_id' => $order->id,
                    'tiket_id' => $tiket->id,
                    'jumlah' => $jumlah,
                    'subtotal_harga' => $subtotal,
                ]);

                $tiket->decrement('stok', $jumlah);
            }

            $order->update(['total_harga' => $total]);
        }
    }
}
