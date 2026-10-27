<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed kategori acara BengTix.
     */
    public function run(): void
    {
        $kategoris = [
            'Konser',
            'Festival',
            'Seminar',
            'Workshop',
            'Olahraga',
            'Pameran',
            'Komedi',
            'Teater',
            'Pendidikan',
            'Teknologi',
            'Bisnis',
            'Musik',
        ];

        foreach ($kategoris as $nama) {
            Kategori::firstOrCreate([
                'nama' => $nama,
            ]);
        }
    }
}
