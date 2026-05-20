<?php

namespace Database\Seeders;

use App\Models\Master\JenisLuaran;
use Illuminate\Database\Seeder;

class JenisLuaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['skema_jenis' => 'penelitian', 'kode' => 'PEN-ART',  'nama' => 'Artikel Ilmiah',         'urutan' => 1],
            ['skema_jenis' => 'penelitian', 'kode' => 'PEN-SEM',  'nama' => 'Publikasi di Seminar',   'urutan' => 2],
            ['skema_jenis' => 'penelitian', 'kode' => 'PEN-HKI',  'nama' => 'HKI',                    'urutan' => 3],
            ['skema_jenis' => 'penelitian', 'kode' => 'PEN-PROD', 'nama' => 'Produk / Prototype',     'urutan' => 4],
            ['skema_jenis' => 'penelitian', 'kode' => 'PEN-LAIN', 'nama' => 'Lainnya',                'urutan' => 5],

            ['skema_jenis' => 'pkm', 'kode' => 'PKM-MEDIA', 'nama' => 'Artikel di Media Massa',  'urutan' => 1],
            ['skema_jenis' => 'pkm', 'kode' => 'PKM-VIDEO', 'nama' => 'Video Kegiatan',          'urutan' => 2],
            ['skema_jenis' => 'pkm', 'kode' => 'PKM-MODUL', 'nama' => 'Modul / Materi Pelatihan','urutan' => 3],
            ['skema_jenis' => 'pkm', 'kode' => 'PKM-POSTER','nama' => 'Poster / Banner',         'urutan' => 4],
            ['skema_jenis' => 'pkm', 'kode' => 'PKM-DOK',   'nama' => 'Dokumentasi Kegiatan',    'urutan' => 5],
            ['skema_jenis' => 'pkm', 'kode' => 'PKM-LAIN',  'nama' => 'Lainnya',                 'urutan' => 6],
        ];

        foreach ($data as $row) {
            JenisLuaran::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
