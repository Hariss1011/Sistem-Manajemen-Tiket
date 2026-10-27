<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use RuntimeException;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $kategoris = Kategori::pluck('id', 'nama');
        $lokasis = Lokasi::pluck('id', 'nama_lokasi');

        $events = [
            [
                'judul' => 'Malam Rock Nusantara',
                'deskripsi' => 'Lima band rock lokal naik panggung dalam satu malam. Pintu dibuka pukul 17.00, area standing dan tribun tersedia.',
                'tanggal_waktu' => now()->addDays(12)->setTime(19, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Istora Senayan, Jakarta',
                'seed' => 'rock',
                'warna1' => '#172554',
                'warna2' => '#2563eb',
                'label' => 'LIVE MUSIC',
            ],
            [
                'judul' => 'Jazz di Taman Budaya',
                'deskripsi' => 'Konser jazz akustik di taman terbuka dengan penampil dari Bali dan Yogyakarta. Bawa alas duduk sendiri.',
                'tanggal_waktu' => now()->addDays(26)->setTime(18, 30),
                'kategori' => 'Konser',
                'lokasi' => 'Taman Budaya, Denpasar',
                'seed' => 'jazz',
                'warna1' => '#312e81',
                'warna2' => '#a855f7',
                'label' => 'JAZZ NIGHT',
            ],
            [
                'judul' => 'Seminar Karier Software Engineer',
                'deskripsi' => 'Praktisi dari startup dan perusahaan teknologi berbagi cara menyusun portofolio, lolos wawancara teknis, dan memilih jalur karier.',
                'tanggal_waktu' => now()->addDays(9)->setTime(9, 0),
                'kategori' => 'Seminar',
                'lokasi' => 'Gedung Sabuga, Bandung',
                'seed' => 'career',
                'warna1' => '#0f172a',
                'warna2' => '#0891b2',
                'label' => 'CAREER & TECH',
            ],
            [
                'judul' => 'Seminar Data & AI untuk Bisnis Lokal',
                'deskripsi' => 'Studi kasus penerapan analitik data dan AI di UMKM, lengkap dengan sesi tanya jawab bersama pembicara.',
                'tanggal_waktu' => now()->addDays(40)->setTime(10, 0),
                'kategori' => 'Seminar',
                'lokasi' => 'Grand City Convex, Surabaya',
                'seed' => 'data',
                'warna1' => '#064e3b',
                'warna2' => '#0d9488',
                'label' => 'DATA & AI',
            ],
            [
                'judul' => 'Workshop Laravel dari Nol sampai Deploy',
                'deskripsi' => 'Bangun aplikasi tiketing sederhana selama satu hari penuh. Peserta membawa laptop sendiri, materi dan sertifikat disediakan.',
                'tanggal_waktu' => now()->addDays(18)->setTime(9, 30),
                'kategori' => 'Workshop',
                'lokasi' => 'Grha Sabha Pramana, Yogyakarta',
                'seed' => 'laravel',
                'warna1' => '#7f1d1d',
                'warna2' => '#ea580c',
                'label' => 'BUILD & DEPLOY',
            ],
            [
                'judul' => 'Workshop UI Design dengan Figma',
                'deskripsi' => 'Latihan membuat desain aplikasi mobile dari wireframe sampai prototipe interaktif, dipandu desainer produk berpengalaman.',
                'tanggal_waktu' => now()->addDays(5)->setTime(13, 0),
                'kategori' => 'Workshop',
                'lokasi' => 'Gedung Sabuga, Bandung',
                'seed' => 'figma',
                'warna1' => '#581c87',
                'warna2' => '#db2777',
                'label' => 'DESIGN WORKSHOP',
            ],
            [
                'judul' => 'Festival Akustik Pantai',
                'deskripsi' => 'Festival musik akustik sore hari dengan panggung menghadap laut. Tiket terbatas.',
                'tanggal_waktu' => now()->addDays(55)->setTime(15, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Taman Budaya, Denpasar',
                'seed' => 'beach',
                'warna1' => '#164e63',
                'warna2' => '#0ea5e9',
                'label' => 'ACOUSTIC FEST',
            ],
            [
                'judul' => 'Konser Reuni Band Kampus',
                'deskripsi' => 'Reuni band kampus lintas angkatan. Event ini sudah selesai.',
                'tanggal_waktu' => now()->subDays(20)->setTime(19, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Istora Senayan, Jakarta',
                'seed' => 'reunion',
                'warna1' => '#334155',
                'warna2' => '#64748b',
                'label' => 'PAST EVENT',
            ],
        ];

        $folderGambar = public_path('images/events');

        File::ensureDirectoryExists($folderGambar);

        foreach ($events as $e) {
            if (! isset($kategoris[$e['kategori']])) {
                throw new RuntimeException(
                    "Kategori '{$e['kategori']}' tidak ditemukan. Periksa CategorySeeder."
                );
            }

            if (! isset($lokasis[$e['lokasi']])) {
                throw new RuntimeException(
                    "Lokasi '{$e['lokasi']}' tidak ditemukan. Periksa LokasiSeeder."
                );
            }

            $judulSvg = htmlspecialchars(
                $e['judul'],
                ENT_QUOTES | ENT_XML1,
                'UTF-8'
            );

            $labelSvg = htmlspecialchars(
                $e['label'],
                ENT_QUOTES | ENT_XML1,
                'UTF-8'
            );

            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="675" viewBox="0 0 1200 675">
    <defs>
        <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="{$e['warna1']}"/>
            <stop offset="100%" stop-color="{$e['warna2']}"/>
        </linearGradient>
        <pattern id="grid" width="42" height="42" patternUnits="userSpaceOnUse">
            <path d="M42 0H0V42" fill="none" stroke="#ffffff" stroke-opacity=".09"/>
        </pattern>
    </defs>
    <rect width="1200" height="675" fill="url(#bg)"/>
    <rect width="1200" height="675" fill="url(#grid)"/>
    <circle cx="1030" cy="120" r="210" fill="#ffffff" fill-opacity=".07"/>
    <circle cx="1100" cy="570" r="270" fill="#ffffff" fill-opacity=".06"/>
    <path d="M0 550 Q350 430 650 560 T1200 480 V675 H0Z" fill="#020617" fill-opacity=".22"/>
    <rect x="76" y="78" width="260" height="48" rx="24" fill="#ffffff" fill-opacity=".15"/>
    <text x="206" y="109" font-family="Arial, Helvetica, sans-serif" font-size="20" font-weight="700" letter-spacing="3" text-anchor="middle" fill="#ffffff">BENGTIX</text>
    <text x="76" y="400" font-family="Arial, Helvetica, sans-serif" font-size="22" font-weight="700" letter-spacing="5" fill="#ffffff" fill-opacity=".8">{$labelSvg}</text>
    <foreignObject x="72" y="420" width="1030" height="170">
        <div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Arial,Helvetica,sans-serif;font-size:48px;font-weight:700;line-height:1.15;color:white;overflow-wrap:break-word;">{$judulSvg}</div>
    </foreignObject>
    <text x="76" y="630" font-family="Arial, Helvetica, sans-serif" font-size="18" letter-spacing="2" fill="#ffffff" fill-opacity=".75">DISCOVER YOUR NEXT EXPERIENCE</text>
</svg>
SVG;

            $namaFile = "seed-{$e['seed']}.svg";

            File::put(
                $folderGambar . DIRECTORY_SEPARATOR . $namaFile,
                $svg
            );

            Event::updateOrCreate(
                ['judul' => $e['judul']],
                [
                    'user_id' => $admin->id,
                    'deskripsi' => $e['deskripsi'],
                    'tanggal_waktu' => $e['tanggal_waktu'],
                    'kategori_id' => $kategoris[$e['kategori']],
                    'lokasi_id' => $lokasis[$e['lokasi']],
                    'gambar' => "images/events/seed-{$e['seed']}.svg",
                ]
            );
        }
    }
}
