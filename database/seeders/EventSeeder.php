<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $kategori = Kategori::pluck('id', 'nama');
        $lokasi = Lokasi::pluck('id', 'nama_lokasi');

        $events = [
            [
                'judul' => 'Malam Rock Nusantara',
                'deskripsi' => 'Lima band rock lokal naik panggung dalam satu malam. Pintu dibuka pukul 17.00, area standing dan tribun tersedia.',
                'tanggal_waktu' => now()->addDays(12)->setTime(19, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Istora Senayan, Jakarta',
                'seed' => 'rock',
            ],
            [
                'judul' => 'Jazz di Taman Budaya',
                'deskripsi' => 'Konser jazz akustik di taman terbuka dengan penampil dari Bali dan Yogyakarta. Bawa alas duduk sendiri.',
                'tanggal_waktu' => now()->addDays(26)->setTime(18, 30),
                'kategori' => 'Konser',
                'lokasi' => 'Taman Budaya, Denpasar',
                'seed' => 'jazz',
            ],
            [
                'judul' => 'Seminar Karier Software Engineer',
                'deskripsi' => 'Praktisi dari startup dan perusahaan teknologi berbagi cara menyusun portofolio, lolos wawancara teknis, dan memilih jalur karier.',
                'tanggal_waktu' => now()->addDays(9)->setTime(9, 0),
                'kategori' => 'Seminar',
                'lokasi' => 'Gedung Sabuga, Bandung',
                'seed' => 'career',
            ],
            [
                'judul' => 'Seminar Data & AI untuk Bisnis Lokal',
                'deskripsi' => 'Studi kasus penerapan analitik data dan AI di UMKM, lengkap dengan sesi tanya jawab bersama pembicara.',
                'tanggal_waktu' => now()->addDays(40)->setTime(10, 0),
                'kategori' => 'Seminar',
                'lokasi' => 'Grand City Convex, Surabaya',
                'seed' => 'data',
            ],
            [
                'judul' => 'Workshop Laravel dari Nol sampai Deploy',
                'deskripsi' => 'Bangun aplikasi tiketing sederhana selama satu hari penuh. Peserta membawa laptop sendiri, materi dan sertifikat disediakan.',
                'tanggal_waktu' => now()->addDays(18)->setTime(9, 30),
                'kategori' => 'Workshop',
                'lokasi' => 'Grha Sabha Pramana, Yogyakarta',
                'seed' => 'laravel',
            ],
            [
                'judul' => 'Workshop UI Design dengan Figma',
                'deskripsi' => 'Latihan membuat desain aplikasi mobile dari wireframe sampai prototipe interaktif, dipandu desainer produk berpengalaman.',
                'tanggal_waktu' => now()->addDays(5)->setTime(13, 0),
                'kategori' => 'Workshop',
                'lokasi' => 'Gedung Sabuga, Bandung',
                'seed' => 'figma',
            ],
            [
                'judul' => 'Festival Akustik Pantai',
                'deskripsi' => 'Festival musik akustik sore hari dengan panggung menghadap laut. Tiket terbatas.',
                'tanggal_waktu' => now()->addDays(55)->setTime(15, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Taman Budaya, Denpasar',
                'seed' => 'beach',
            ],
            [
                // Event yang sudah lewat, untuk menguji tampilan "Selesai".
                'judul' => 'Konser Reuni Band Kampus',
                'deskripsi' => 'Reuni band kampus lintas angkatan. Event ini sudah selesai.',
                'tanggal_waktu' => now()->subDays(20)->setTime(19, 0),
                'kategori' => 'Konser',
                'lokasi' => 'Istora Senayan, Jakarta',
                'seed' => 'reunion',
            ],
        ];

        foreach ($events as $e) {
            Event::create([
                'user_id' => $admin->id,
                'judul' => $e['judul'],
                'deskripsi' => $e['deskripsi'],
                'tanggal_waktu' => $e['tanggal_waktu'],
                'kategori_id' => $kategori[$e['kategori']],
                'lokasi_id' => $lokasi[$e['lokasi']],
                'gambar' => "seed-{$e['seed']}.svg",
            ]);
        }
    }
}
