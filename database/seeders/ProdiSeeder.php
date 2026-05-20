<?php

namespace Database\Seeders;

use App\Models\Master\Fakultas;
use App\Models\Master\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'FT' => [
                ['kode' => 'TS',  'nama' => 'Teknik Sipil',       'jenjang' => 'S1'],
                ['kode' => 'TE',  'nama' => 'Teknik Elektro',     'jenjang' => 'S1'],
                ['kode' => 'TI',  'nama' => 'Teknik Industri',    'jenjang' => 'S1'],
                ['kode' => 'TL',  'nama' => 'Teknik Lingkungan',  'jenjang' => 'S1'],
            ],
            'FIK' => [
                ['kode' => 'SI',  'nama' => 'Sistem Informasi',   'jenjang' => 'S1'],
                ['kode' => 'TIF', 'nama' => 'Teknik Informatika', 'jenjang' => 'S1'],
            ],
            'FE' => [
                ['kode' => 'MJ',  'nama' => 'Manajemen',          'jenjang' => 'S1'],
                ['kode' => 'AK',  'nama' => 'Akuntansi',          'jenjang' => 'S1'],
            ],
            'FKIP' => [
                ['kode' => 'PBI', 'nama' => 'Pendidikan Bahasa Inggris', 'jenjang' => 'S1'],
                ['kode' => 'PAUD','nama' => 'PG-PAUD',                    'jenjang' => 'S1'],
                ['kode' => 'PMTK','nama' => 'Pendidikan Matematika',      'jenjang' => 'S1'],
            ],
            'FH' => [
                ['kode' => 'IH',  'nama' => 'Ilmu Hukum',         'jenjang' => 'S1'],
            ],
            'FK' => [
                ['kode' => 'PD',  'nama' => 'Pendidikan Dokter',           'jenjang' => 'S1'],
                ['kode' => 'PPD', 'nama' => 'Pendidikan Profesi Dokter',   'jenjang' => 'Profesi'],
            ],
            'FPSI' => [
                ['kode' => 'PSI', 'nama' => 'Psikologi',          'jenjang' => 'S1'],
            ],
        ];

        foreach ($map as $kodeFak => $prodiList) {
            $fakultas = Fakultas::where('kode', $kodeFak)->first();
            if (! $fakultas) {
                continue;
            }

            foreach ($prodiList as $prodi) {
                Prodi::updateOrCreate(
                    ['kode' => $prodi['kode']],
                    array_merge($prodi, ['fakultas_id' => $fakultas->id])
                );
            }
        }
    }
}
