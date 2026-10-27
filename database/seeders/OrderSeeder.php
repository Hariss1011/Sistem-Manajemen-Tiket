<?php

namespace Database\Seeders;

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->firstOrFail();

        // [judul event, hari lalu, [[urutan tiket, jumlah], ...]]
        $pesanan = [
            ['Konser Reuni Band Kampus', 25, [[0, 2]]],
            ['Malam Rock Nusantara', 6, [[0, 1], [1, 2]]],
            ['Workshop Laravel dari Nol sampai Deploy', 3, [[0, 1]]],
        ];

        foreach ($pesanan as [$judul, $hariLalu, $baris]) {
            $event = Event::where('judul', $judul)->firstOrFail();

            $tikets = $event->tikets()
                ->orderBy('id')
                ->get();

            $total = 0;
            $detailPesanan = [];

            foreach ($baris as [$urutan, $jumlah]) {
                if (! isset($tikets[$urutan])) {
                    throw new RuntimeException(
                        "Tiket urutan {$urutan} tidak ditemukan untuk event '{$judul}'. Periksa TicketSeeder."
                    );
                }

                $tiket = $tikets[$urutan];

                if ($tiket->stok < $jumlah) {
                    throw new RuntimeException(
                        "Stok tiket '{$judul}' tidak mencukupi untuk data pesanan seeder."
                    );
                }

                $subtotal = $tiket->harga * $jumlah;
                $total += $subtotal;

                $detailPesanan[] = [
                    'tiket' => $tiket,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'order_date' => now()->subDays($hariLalu),
                'total_harga' => $total,
            ]);

            foreach ($detailPesanan as $detail) {
                DetailOrder::create([
                    'order_id' => $order->id,
                    'tiket_id' => $detail['tiket']->id,
                    'jumlah' => $detail['jumlah'],
                    'subtotal_harga' => $detail['subtotal'],
                ]);

                $detail['tiket']->decrement(
                    'stok',
                    $detail['jumlah']
                );
            }
        }
    }
}
