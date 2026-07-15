<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Persiapan GO-LIVE.
 *
 * MENGHAPUS:
 *  - Seluruh data transaksi proposal + turunannya (anggota, mitra, RAB, dokumen,
 *    verifikasi, penugasan reviewer, penilaian, revisi, laporan, luaran, rencana luaran),
 *    serta notifikasi & log aktivitas.
 *  - Seluruh data dosen: akun login (role=dosen), profil dosen, keahlian, dan
 *    riwayat penelitian/PKM/HKI.
 *
 * MEMPERTAHANKAN:
 *  - Periode hibah, jadwal tahapan, periode laporan.
 *  - Semua master data (fakultas, prodi, keahlian, skema, tahapan, kriteria,
 *    jenis luaran, kategori/komponen RAB, bidang strategis, pengaturan).
 *  - Semua akun operator yang sudah ada.
 *
 * MENAMBAH akun operator (password: "password"):
 *  operator1, operator2, hafizd, oji
 *
 * CARA JALANKAN (BACKUP DATABASE DULU — operasi ini TIDAK BISA dibatalkan):
 *  php artisan db:seed --class=GoLiveSeeder            (interaktif: ketik "yes")
 *  GOLIVE_FORCE=1 php artisan db:seed --class=GoLiveSeeder --force   (tanpa prompt)
 */
class GoLiveSeeder extends Seeder
{
    public function run(): void
    {
        // Konfirmasi interaktif (fail-closed: kalau --no-interaction, default batal).
        // Lewati prompt dengan env GOLIVE_FORCE=1 untuk eksekusi non-interaktif.
        $force = getenv('GOLIVE_FORCE') === '1';
        if (! $force && $this->command && ! $this->command->confirm(
            'Ini akan MENGHAPUS semua data transaksi proposal & data dosen (akun, profil, riwayat). Lanjutkan?',
            false
        )) {
            $this->command->warn('Dibatalkan. Tidak ada data yang dihapus.');
            return;
        }

        // Transaksi proposal + output dosen/reviewer/operator.
        $transaksiTables = [
            'log_aktivitas_t',
            'notifikasi_t',
            'luaran_t',
            'laporan_akhir_t',
            'laporan_kemajuan_t',
            'revisi_proposal_t',
            'penilaian_detail_t',
            'penilaian_t',
            'penugasan_reviewer_t',
            'verifikasi_proposal_t',
            'rencana_luaran_t',
            'proposal_dokumen_t',
            'proposal_rab_t',
            'proposal_mitra_t',
            'proposal_anggota_t',
            'proposal_t',
        ];

        // Data milik dosen.
        $dosenTables = [
            'riwayat_penelitian_t',
            'riwayat_pkm_t',
            'riwayat_hki_t',
            'dosen_keahlian_m',
            'dosen_m',
        ];

        Schema::disableForeignKeyConstraints();
        try {
            foreach (array_merge($transaksiTables, $dosenTables) as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }

            // Hapus akun login dosen; akun operator dipertahankan.
            User::where('role', 'dosen')->delete();
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        // Tambah akun operator (idempotent berdasarkan username; password di-reset ke "password").
        $operators = [
            ['username' => 'operator1', 'nik' => 'OP-OPERATOR1', 'email' => 'operator1@univbatam.ac.id'],
            ['username' => 'operator2', 'nik' => 'OP-OPERATOR2', 'email' => 'operator2@univbatam.ac.id'],
            ['username' => 'hafizd',    'nik' => 'OP-HAFIZD',    'email' => 'hafizd@univbatam.ac.id'],
            ['username' => 'oji',       'nik' => 'OP-OJI',       'email' => 'oji@univbatam.ac.id'],
        ];

        foreach ($operators as $op) {
            User::updateOrCreate(
                ['username' => $op['username']],
                [
                    'nik'       => $op['nik'],
                    'email'     => $op['email'],
                    'password'  => 'password',
                    'role'      => 'operator',
                    'is_active' => true,
                ]
            );
        }

        $this->command?->info('Go-live selesai: data transaksi & dosen dibersihkan; operator1, operator2, hafizd, oji ditambahkan (password: "password").');
    }
}
