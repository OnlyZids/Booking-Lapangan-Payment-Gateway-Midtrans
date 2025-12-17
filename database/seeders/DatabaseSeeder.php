<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin SmashZone',
            'email' => 'admin@smashzone.com',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Buat Akun User Biasa
        User::create([
            'name' => 'Badminton Lover',
            'email' => 'user@gmail.com',
            'phone' => '089876543210',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);
    }
}
