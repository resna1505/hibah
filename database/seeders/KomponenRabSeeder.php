<?php

namespace Database\Seeders;

use App\Models\Master\KategoriRab;
use App\Models\Master\KomponenRab;
use Illuminate\Database\Seeder;

class KomponenRabSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'honor' => [
                ['kode' => 'honor_narasumber',  'nama' => 'Honorarium Narasumber'],
                ['kode' => 'honor_pengumpul',   'nama' => 'Honorarium Pengumpul Data'],
                ['kode' => 'honor_pengolah',    'nama' => 'Honorarium Pengolah Data'],
                ['kode' => 'honor_sekretariat', 'nama' => 'Honorarium Sekretariat'],
            ],
            'bahan' => [
                ['kode' => 'atk',               'nama' => 'ATK'],
                ['kode' => 'bahan_penelitian',  'nama' => 'Bahan Penelitian (habis pakai)'],
                ['kode' => 'barang_persediaan', 'nama' => 'Barang Persediaan'],
                ['kode' => 'cetak_jilid',       'nama' => 'Penggandaan & Jilid'],
            ],
            'perjalanan' => [
                ['kode' => 'transport_lokal',   'nama' => 'Transport Lokal'],
                ['kode' => 'perjalanan_dinas',  'nama' => 'Perjalanan Dinas (luar kota)'],
                ['kode' => 'akomodasi',         'nama' => 'Akomodasi'],
                ['kode' => 'uang_harian',       'nama' => 'Uang Harian'],
            ],
            'luaran' => [
                ['kode' => 'publikasi_jurnal',  'nama' => 'Publikasi Jurnal / APC'],
                ['kode' => 'seminar',           'nama' => 'Seminar / Konferensi'],
                ['kode' => 'haki',              'nama' => 'Pendaftaran HKI / Paten'],
                ['kode' => 'luaran_lain',       'nama' => 'Luaran Lain (buku, prototipe)'],
            ],
        ];

        foreach ($map as $kodeKel => $rows) {
            $kategori = KategoriRab::where('kode', $kodeKel)->first();
            if (! $kategori) continue;
            foreach ($rows as $i => $row) {
                KomponenRab::updateOrCreate(
                    ['kategori_rab_id' => $kategori->id, 'kode' => $row['kode']],
                    ['nama' => $row['nama'], 'urutan' => $i + 1, 'is_active' => true],
                );
            }
        }
    }
}
