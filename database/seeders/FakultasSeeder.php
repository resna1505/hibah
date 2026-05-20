<?php

namespace Database\Seeders;

use App\Models\Master\Fakultas;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'FT',    'nama' => 'Fakultas Teknik'],
            ['kode' => 'FIK',   'nama' => 'Fakultas Ilmu Komputer'],
            ['kode' => 'FE',    'nama' => 'Fakultas Ekonomi'],
            ['kode' => 'FKIP',  'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['kode' => 'FH',    'nama' => 'Fakultas Hukum'],
            ['kode' => 'FK',    'nama' => 'Fakultas Kedokteran'],
            ['kode' => 'FPSI',  'nama' => 'Fakultas Psikologi'],
        ];

        foreach ($data as $row) {
            Fakultas::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
