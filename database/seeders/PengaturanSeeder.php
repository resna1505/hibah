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
            ['kunci' => 'kop_kiri_path',       'label' => 'Logo Kop Kiri (mis. UNIBA)',  'tipe' => 'image','grup' => 'lppm', 'nilai' => null],
            ['kunci' => 'kop_kanan_path',      'label' => 'Logo Kop Kanan (mis. LPPM)',  'tipe' => 'image','grup' => 'lppm', 'nilai' => null],
            ['kunci' => 'institusi_nama',      'label' => 'Nama Institusi',      'tipe' => 'text', 'grup' => 'institusi', 'nilai' => 'Universitas Batam'],
            ['kunci' => 'institusi_kota',      'label' => 'Kota',                'tipe' => 'text', 'grup' => 'institusi', 'nilai' => 'Batam'],
            ['kunci' => 'institusi_kode',      'label' => 'Kode Institusi (utk no. registrasi)', 'tipe' => 'text', 'grup' => 'institusi', 'nilai' => 'LPPM-UNIBA'],
            ['kunci' => 'proposal_no_format',  'label' => 'Format Nomor Registrasi Proposal',     'tipe' => 'text', 'grup' => 'institusi', 'nilai' => '{kode}/{jenis}/{tahun}/{seq:3}'],
        ];

        foreach ($data as $row) {
            Pengaturan::updateOrCreate(['kunci' => $row['kunci']], $row);
        }
    }
}
