<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Seed lokasi acara BengTix.
     */
    public function run(): void
    {
        $lokasis = [
            'Istora Senayan, Jakarta',
            'Jakarta International Expo, Jakarta',
            'The Kasablanka Hall, Jakarta',
            'ICE BSD, Tangerang',
            'Gedung Sabuga, Bandung',
            'Trans Convention Centre, Bandung',
            'Grha Sabha Pramana, Yogyakarta',
            'Jogja Expo Center, Yogyakarta',
            'Grand City Convex, Surabaya',
            'Jatim International Expo, Surabaya',
            'Taman Budaya, Denpasar',
            'Bali Nusa Dua Convention Center, Bali',
            'Edutorium Universitas Muhammadiyah Surakarta, Solo',
            'Semarang Convention Center, Semarang',
            'Trans Studio Makassar, Makassar',
            'Medan International Convention Center, Medan',
        ];

        foreach ($lokasis as $nama) {
            Lokasi::firstOrCreate([
                'nama_lokasi' => $nama,
            ]);
        }
    }
}
