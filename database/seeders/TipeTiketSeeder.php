<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipeTiket;

class TipeTiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipeTiket = [
            ['nama_tipe' => 'VIP'],
            ['nama_tipe' => 'Regular'],
            ['nama_tipe' => 'Economy'],
        ];

        foreach ($tipeTiket as $tipe) {
            TipeTiket::create(['nama' => $tipe['nama_tipe']]);
        }
    }
}
