<?php

namespace Database\Seeders;

use App\Models\Peminjam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PeminjamSeeder extends Seeder
{
    public function run(): void
    {
        Peminjam::create([
            'nama' => 'Admin Lab',
            'email' => 'admin@tefa.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '081234567890',
            'alamat' => 'Lab TEFA PPLG',
            'role' => 'admin',
        ]);

        Peminjam::create([
            'nama' => 'User Biasa',
            'email' => 'user@tefa.com',
            'password' => Hash::make('user123'),
            'no_hp' => '089876543210',
            'alamat' => 'Siswa PPLG',
            'role' => 'user',
        ]);
    }
}