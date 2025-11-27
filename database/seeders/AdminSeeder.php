<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@campus.com', // Email untuk login nanti
            'password' => Hash::make('admin123'), // Passwordnya
            'role' => 'admin',
        ]);

        // Buat 1 Akun Pemilih (Contoh)
        User::create([
            'name' => 'Mahasiswa 01',
            'email' => 'mhs01@campus.com',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'voter',
        ]);
    }
}
