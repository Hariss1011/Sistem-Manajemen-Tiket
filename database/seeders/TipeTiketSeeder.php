<?php

namespace Database\Seeders;

use App\Models\TipeTiket;
use Illuminate\Database\Seeder;

class TipeTiketSeeder extends Seeder
{
    /**
     * Seed tipe tiket BengTix.
     */
    public function run(): void
    {
        $tipeTiket = [
            'Regular',
            'Economy',
            'VIP',
            'VVIP',
            'Early Bird',
            'Presale',
        ];

        foreach ($tipeTiket as $nama) {
            TipeTiket::firstOrCreate([
                'nama' => $nama,
            ]);
        }
    }
}
