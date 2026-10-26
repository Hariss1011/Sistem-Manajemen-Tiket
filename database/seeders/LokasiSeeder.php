<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasis = [
            'Istora Senayan, Jakarta',
            'Gedung Sabuga, Bandung',
            'Grha Sabha Pramana, Yogyakarta',
            'Grand City Convex, Surabaya',
            'Taman Budaya, Denpasar',
        ];

        foreach ($lokasis as $nama) {
            Lokasi::create(['nama_lokasi' => $nama]);
        }
    }
}
