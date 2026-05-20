<?php

namespace Database\Seeders;

use App\Models\Master\KriteriaPenilaian;
use App\Models\Master\SkemaHibah;
use Illuminate\Database\Seeder;

class KriteriaPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'PEN-INT' => [
                ['urutan' => 1, 'nama' => 'Kebaruan Penelitian',  'bobot_persen' => 20, 'deskripsi' => 'Tingkat orisinalitas dan kebaruan topik penelitian'],
                ['urutan' => 2, 'nama' => 'Metodologi Penelitian','bobot_persen' => 20, 'deskripsi' => 'Kelayakan dan ketepatan metode yang digunakan'],
                ['urutan' => 3, 'nama' => 'Kelayakan Anggaran',   'bobot_persen' => 20, 'deskripsi' => 'Kewajaran dan justifikasi RAB'],
                ['urutan' => 4, 'nama' => 'Luaran Penelitian',    'bobot_persen' => 20, 'deskripsi' => 'Kualitas dan kelayakan target luaran'],
                ['urutan' => 5, 'nama' => 'Jadwal Penelitian',    'bobot_persen' => 20, 'deskripsi' => 'Realistis dan terukur sesuai durasi'],
            ],
            'PKM-INT' => [
                ['urutan' => 1, 'nama' => 'Urgensi & Manfaat untuk Mitra', 'bobot_persen' => 20, 'deskripsi' => 'Kebutuhan mitra dan dampak yang dihasilkan'],
                ['urutan' => 2, 'nama' => 'Metode Pelaksanaan',            'bobot_persen' => 20, 'deskripsi' => 'Ketepatan tahapan pelaksanaan PKM'],
                ['urutan' => 3, 'nama' => 'Kelayakan Anggaran',            'bobot_persen' => 20, 'deskripsi' => 'Kewajaran dan justifikasi RAB'],
                ['urutan' => 4, 'nama' => 'Luaran PKM',                    'bobot_persen' => 20, 'deskripsi' => 'Kualitas dan kelayakan target luaran'],
                ['urutan' => 5, 'nama' => 'Jadwal Pelaksanaan',            'bobot_persen' => 20, 'deskripsi' => 'Realistis dan terukur sesuai durasi'],
            ],
        ];

        foreach ($map as $kodeSkema => $kriteriaList) {
            $skema = SkemaHibah::where('kode', $kodeSkema)->first();
            if (! $skema) {
                continue;
            }

            foreach ($kriteriaList as $kriteria) {
                KriteriaPenilaian::updateOrCreate(
                    ['skema_hibah_id' => $skema->id, 'urutan' => $kriteria['urutan']],
                    array_merge($kriteria, ['skema_hibah_id' => $skema->id])
                );
            }
        }
    }
}
