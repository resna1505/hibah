<?php

namespace Database\Seeders;

use App\Models\Master\Dosen;
use App\Models\Master\SkemaHibah;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProposalDummySeeder extends Seeder
{
    public function run(): void
    {
        $periode = PeriodeHibah::aktif()->first();
        if (! $periode) {
            return;
        }

        $pen = SkemaHibah::where('kode', 'PEN-INT')->first();
        $pkm = SkemaHibah::where('kode', 'PKM-INT')->first();

        // Map: nidn => [ketua nama short]
        $dosenByNidn = Dosen::all()->keyBy('nidn');

        $rows = [
            [
                'nidn' => '1025038801', // Andi
                'skema' => $pen->id,
                'judul' => 'Pengembangan Sistem Informasi Akademik Terintegrasi',
                'status' => 'direview',
                'anggaran' => 22_000_000,
                'submit_offset' => -30,
            ],
            [
                'nidn' => '1015038002', // Nia
                'skema' => $pen->id,
                'judul' => 'Studi Efektivitas Pembelajaran Berbasis E-Learning',
                'status' => 'disetujui',
                'anggaran' => 18_000_000,
                'submit_offset' => -32,
            ],
            [
                'nidn' => '1010057503', // Desi
                'skema' => $pen->id,
                'judul' => 'Pemanfaatan Energi Terbarukan untuk Kampus Hijau',
                'status' => 'submitted',
                'anggaran' => 25_000_000,
                'submit_offset' => -3,
            ],
            [
                'nidn' => '1025098204', // Welly
                'skema' => $pkm->id,
                'judul' => 'Pengembangan UMKM Melalui Digital Marketing',
                'status' => 'revisi_minor',
                'anggaran' => 12_000_000,
                'submit_offset' => -28,
            ],
            [
                'nidn' => '1015019005', // Raymond
                'skema' => $pen->id,
                'judul' => 'Analisis Persepsi Penyaluran KUR bagi UMKM di Kota Batam',
                'status' => 'ditolak',
                'anggaran' => 15_000_000,
                'submit_offset' => -29,
            ],
            [
                'nidn' => '1020039206', // Rina
                'skema' => $pkm->id,
                'judul' => 'Pelatihan Digital Marketing untuk UMKM Kuliner',
                'status' => 'verifikasi',
                'anggaran' => 10_000_000,
                'submit_offset' => -5,
            ],
            [
                'nidn' => '1005127807', // Ikhsan
                'skema' => $pen->id,
                'judul' => 'Analisis Kinerja Struktur Beton Ringan untuk Bangunan Bertingkat',
                'status' => 'direview',
                'anggaran' => 24_000_000,
                'submit_offset' => -27,
            ],
        ];

        foreach ($rows as $r) {
            $dosen = $dosenByNidn[$r['nidn']] ?? null;
            if (! $dosen) {
                continue;
            }

            Proposal::updateOrCreate(
                [
                    'periode_hibah_id' => $periode->id,
                    'ketua_dosen_id' => $dosen->id,
                    'skema_hibah_id' => $r['skema'],
                ],
                [
                    'judul' => $r['judul'],
                    'ringkasan' => 'Ringkasan dummy untuk keperluan seeding dashboard.',
                    'kata_kunci' => 'dummy; seeder; demo',
                    'total_anggaran' => $r['anggaran'],
                    'durasi_bulan' => 8,
                    'status' => $r['status'],
                    'pernyataan_setuju' => true,
                    'tgl_submit' => Carbon::now()->addDays($r['submit_offset']),
                ]
            );
        }
    }
}
