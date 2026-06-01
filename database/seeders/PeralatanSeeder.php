<?php

namespace Database\Seeders;

use App\Models\Peralatan;
use Illuminate\Database\Seeder;

class PeralatanSeeder extends Seeder
{
    public function run(): void
    {
        $peralatan = [
            ['nama' => 'Proyektor Epson', 'kode' => 'PRJ001', 'stok' => 3],
            ['nama' => 'Laptop Asus', 'kode' => 'LAP001', 'stok' => 5],
            ['nama' => 'Whiteboard', 'kode' => 'WBD001', 'stok' => 2],
            ['nama' => 'Kamera DSLR', 'kode' => 'CAM001', 'stok' => 2],
            ['nama' => 'Microphone Wireless', 'kode' => 'MIC001', 'stok' => 4],
        ];

        foreach ($peralatan as $item) {
            Peralatan::create($item);
        }
    }
}