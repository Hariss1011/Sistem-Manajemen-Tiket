<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tiket;
use App\Models\TipeTiket;
use Illuminate\Database\Seeder;
use RuntimeException;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'event' => 'Malam Rock Nusantara',
                'tipe_tiket' => 'VIP',
                'harga' => 1500000,
                'stok' => 100,
            ],
            [
                'event' => 'Malam Rock Nusantara',
                'tipe_tiket' => 'Regular',
                'harga' => 500000,
                'stok' => 500,
            ],
            [
                'event' => 'Jazz di Taman Budaya',
                'tipe_tiket' => 'Regular',
                'harga' => 250000,
                'stok' => 300,
            ],
            [
                'event' => 'Seminar Karier Software Engineer',
                'tipe_tiket' => 'Regular',
                'harga' => 200000,
                'stok' => 200,
            ],
            [
                'event' => 'Seminar Karier Software Engineer',
                'tipe_tiket' => 'VIP',
                'harga' => 350000,
                'stok' => 50,
            ],
            [
                'event' => 'Seminar Data & AI untuk Bisnis Lokal',
                'tipe_tiket' => 'Regular',
                'harga' => 300000,
                'stok' => 200,
            ],
            [
                'event' => 'Workshop Laravel dari Nol sampai Deploy',
                'tipe_tiket' => 'Early Bird',
                'harga' => 200000,
                'stok' => 75,
            ],
            [
                'event' => 'Workshop Laravel dari Nol sampai Deploy',
                'tipe_tiket' => 'Regular',
                'harga' => 300000,
                'stok' => 125,
            ],
            [
                'event' => 'Workshop UI Design dengan Figma',
                'tipe_tiket' => 'Regular',
                'harga' => 150000,
                'stok' => 100,
            ],
            [
                'event' => 'Festival Akustik Pantai',
                'tipe_tiket' => 'Economy',
                'harga' => 100000,
                'stok' => 400,
            ],
            [
                'event' => 'Festival Akustik Pantai',
                'tipe_tiket' => 'VIP',
                'harga' => 350000,
                'stok' => 80,
            ],
            [
                'event' => 'Konser Reuni Band Kampus',
                'tipe_tiket' => 'Regular',
                'harga' => 150000,
                'stok' => 100,
            ],
        ];

        foreach ($tickets as $ticketData) {
            $event = Event::where('judul', $ticketData['event'])
                ->first();

            if (! $event) {
                throw new RuntimeException(
                    "Event '{$ticketData['event']}' tidak ditemukan. Periksa EventSeeder."
                );
            }

            $tipeTiket = TipeTiket::where(
                'nama',
                $ticketData['tipe_tiket']
            )->first();

            if (! $tipeTiket) {
                throw new RuntimeException(
                    "Tipe tiket '{$ticketData['tipe_tiket']}' tidak ditemukan. Periksa TipeTiketSeeder."
                );
            }

            Tiket::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'tipe_tiket_id' => $tipeTiket->id,
                ],
                [
                    'harga' => $ticketData['harga'],
                    'stok' => $ticketData['stok'],
                ]
            );
        }
    }
}
