<?php

namespace Database\Seeders;

use App\Models\Master\Keahlian;
use Illuminate\Database\Seeder;

class KeahlianSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
            'Sistem Informasi',
            'Rekayasa Perangkat Lunak',
            'Basis Data',
            'Teknologi Informasi',
            'Jaringan Komputer',
            'Keamanan Sistem',
            'Kecerdasan Buatan',
            'Machine Learning',
            'Data Science',
            'Energi Terbarukan',
            'Teknik Lingkungan',
            'Teknik Sipil',
            'Struktur',
            'Manajemen',
            'Kewirausahaan',
            'Akuntansi',
            'Keuangan',
            'Pemasaran Digital',
            'Pendidikan',
            'E-Learning',
            'Psikologi Pendidikan',
            'Hukum Bisnis',
            'Kesehatan Masyarakat',
        ];

        foreach ($list as $nama) {
            Keahlian::updateOrCreate(['nama' => $nama], ['nama' => $nama]);
        }
    }
}
