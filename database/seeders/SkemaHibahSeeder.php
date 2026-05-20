<?php

namespace Database\Seeders;

use App\Models\Master\SkemaHibah;
use Illuminate\Database\Seeder;

class SkemaHibahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode' => 'PEN-INT',
                'jenis' => 'penelitian',
                'nama' => 'Penelitian Internal',
                'deskripsi' => 'Hibah Penelitian Internal LPPM Universitas Batam',
                'max_anggaran' => 25_000_000,
                'max_durasi_bulan' => 12,
                'max_anggota_dosen' => 2,
                'max_anggota_mahasiswa' => 2,
            ],
            [
                'kode' => 'PKM-INT',
                'jenis' => 'pkm',
                'nama' => 'PKM Internal',
                'deskripsi' => 'Hibah Pengabdian Kepada Masyarakat Internal LPPM Universitas Batam',
                'max_anggaran' => 15_000_000,
                'max_durasi_bulan' => 8,
                'max_anggota_dosen' => 2,
                'max_anggota_mahasiswa' => 3,
            ],
        ];

        foreach ($data as $row) {
            SkemaHibah::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
