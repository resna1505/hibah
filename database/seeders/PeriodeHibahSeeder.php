<?php

namespace Database\Seeders;

use App\Models\Master\TahapanHibah;
use App\Models\Transaction\JadwalTahapan;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\PeriodeLaporan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PeriodeHibahSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = (int) now()->year;

        $periode = PeriodeHibah::updateOrCreate(
            ['tahun' => $tahun],
            [
                'nama' => "Hibah Internal {$tahun}",
                'status' => 'aktif',
                'keterangan' => 'Periode aktif hibah penelitian dan PKM internal LPPM Universitas Batam',
            ]
        );

        // Jadwal 6 tahapan dengan status yang menggambarkan progress saat ini
        $today = Carbon::today();
        $jadwal = [
            'pengajuan'  => ['mulai' => $today->copy()->subDays(45), 'selesai' => $today->copy()->subDays(15), 'status' => 'selesai'],
            'review'     => ['mulai' => $today->copy()->subDays(14), 'selesai' => $today->copy()->addDays(5),  'status' => 'berjalan'],
            'revisi'     => ['mulai' => $today->copy()->addDays(6),  'selesai' => $today->copy()->addDays(20), 'status' => 'belum_mulai'],
            'penetapan'  => ['mulai' => $today->copy()->addDays(21), 'selesai' => $today->copy()->addDays(25), 'status' => 'belum_mulai'],
            'pengumuman' => ['mulai' => $today->copy()->addDays(28), 'selesai' => $today->copy()->addDays(28), 'status' => 'belum_mulai'],
            'pelaksanaan'=> ['mulai' => $today->copy()->addDays(30), 'selesai' => $today->copy()->addDays(210),'status' => 'belum_mulai'],
        ];

        foreach ($jadwal as $kode => $rows) {
            $tahapan = TahapanHibah::where('kode', $kode)->first();
            if (! $tahapan) {
                continue;
            }

            JadwalTahapan::updateOrCreate(
                ['periode_hibah_id' => $periode->id, 'tahapan_hibah_id' => $tahapan->id],
                [
                    'tgl_mulai' => $rows['mulai'],
                    'tgl_selesai' => $rows['selesai'],
                    'status' => $rows['status'],
                ]
            );
        }

        // Periode laporan kemajuan (untuk Penelitian dan PKM, masing-masing 2x: 50% dan 100%)
        foreach (['penelitian', 'pkm'] as $skemaJenis) {
            foreach ([
                ['urutan' => 1, 'label' => 'Kemajuan 50%',  'offset' => 90],
                ['urutan' => 2, 'label' => 'Kemajuan 100%', 'offset' => 180],
            ] as $row) {
                PeriodeLaporan::updateOrCreate(
                    [
                        'periode_hibah_id' => $periode->id,
                        'skema_jenis' => $skemaJenis,
                        'urutan' => $row['urutan'],
                    ],
                    [
                        'label' => $row['label'],
                        'batas_unggah' => $today->copy()->addDays($row['offset']),
                    ]
                );
            }
        }
    }
}
