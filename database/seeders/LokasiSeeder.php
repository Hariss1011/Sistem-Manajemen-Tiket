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
        $Lokasis = [
            ['nama_lokasi' => 'Konser'],
            ['nama_lokasi' => 'Seminar'],
            ['nama_lokasi' => 'Workshop'],
        ];

        foreach ($Lokasis as $lokasi) {
            Lokasi::create(['nama_lokasi' => $lokasi['nama_lokasi']]);
        }
    }
}
