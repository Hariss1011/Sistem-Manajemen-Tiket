<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed akun demo BengTix.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin BengTix',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567890',
                'role' => 'admin',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567891',
                'role' => 'user',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567892',
                'role' => 'user',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567893',
                'role' => 'user',
            ],
            [
                'name' => 'Dina Permata',
                'email' => 'dina@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567894',
                'role' => 'user',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '081234567895',
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
