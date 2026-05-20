<?php

namespace Database\Seeders;

use App\Models\Master\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kunci' => 'lppm_ketua_nama',     'label' => 'Nama Ketua LPPM',     'tipe' => 'text', 'grup' => 'lppm', 'nilai' => 'Dr. H. Andi Wijaya, S.E., M.M.'],
            ['kunci' => 'lppm_ketua_nidn',     'label' => 'NIDN/NIP Ketua LPPM', 'tipe' => 'text', 'grup' => 'lppm', 'nilai' => '0101010101'],
            ['kunci' => 'lppm_ketua_jabatan',  'label' => 'Jabatan',             'tipe' => 'text', 'grup' => 'lppm', 'nilai' => 'Ketua LPPM Universitas Batam'],
            ['kunci' => 'lppm_ttd_path',       'label' => 'Tanda Tangan (file)', 'tipe' => 'image','grup' => 'lppm', 'nilai' => null],
            ['kunci' => 'lppm_kop_path',       'label' => 'Kop Surat (file)',    'tipe' => 'image','grup' => 'lppm', 'nilai' => null],
            ['kunci' => 'institusi_nama',      'label' => 'Nama Institusi',      'tipe' => 'text', 'grup' => 'institusi', 'nilai' => 'Universitas Batam'],
            ['kunci' => 'institusi_kota',      'label' => 'Kota',                'tipe' => 'text', 'grup' => 'institusi', 'nilai' => 'Batam'],
        ];

        foreach ($data as $row) {
            Pengaturan::updateOrCreate(['kunci' => $row['kunci']], $row);
        }
    }
}
