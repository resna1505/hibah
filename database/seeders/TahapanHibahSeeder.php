<?php

namespace Database\Seeders;

use App\Models\Master\TahapanHibah;
use Illuminate\Database\Seeder;

class TahapanHibahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['urutan' => 1, 'kode' => 'pengajuan',   'nama' => 'Pengajuan Proposal',  'icon' => 'file-text',  'deskripsi' => 'Periode pengajuan proposal oleh peneliti/pengusul'],
            ['urutan' => 2, 'kode' => 'review',      'nama' => 'Review Proposal',     'icon' => 'users',      'deskripsi' => 'Proses review proposal oleh reviewer'],
            ['urutan' => 3, 'kode' => 'revisi',      'nama' => 'Revisi Proposal',     'icon' => 'edit',       'deskripsi' => 'Periode revisi proposal oleh pengusul'],
            ['urutan' => 4, 'kode' => 'penetapan',   'nama' => 'Penetapan Penerima',  'icon' => 'check-square','deskripsi' => 'Penetapan proposal yang didanai'],
            ['urutan' => 5, 'kode' => 'pengumuman',  'nama' => 'Pengumuman Hasil',    'icon' => 'megaphone',  'deskripsi' => 'Pengumuman penerima hibah internal'],
            ['urutan' => 6, 'kode' => 'pelaksanaan', 'nama' => 'Pelaksanaan Hibah',   'icon' => 'briefcase',  'deskripsi' => 'Pelaksanaan kegiatan penelitian/PKM sesuai kontrak'],
        ];

        foreach ($data as $row) {
            TahapanHibah::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
