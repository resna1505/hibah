<?php

namespace Database\Seeders;

use App\Models\Master\KategoriRab;
use Illuminate\Database\Seeder;

class KategoriRabSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['urutan' => 1, 'kode' => 'honor',     'nama' => 'Honorarium Tim'],
            ['urutan' => 2, 'kode' => 'bahan',     'nama' => 'Bahan Habis Pakai'],
            ['urutan' => 3, 'kode' => 'perjalanan','nama' => 'Perjalanan'],
            ['urutan' => 4, 'kode' => 'luaran',    'nama' => 'Luaran'],
        ];

        foreach ($data as $row) {
            KategoriRab::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
