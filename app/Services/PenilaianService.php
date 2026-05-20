<?php

namespace App\Services;

use App\Models\Transaction\Penilaian;
use App\Models\Transaction\PenilaianDetail;
use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\Proposal;
use Illuminate\Support\Facades\DB;

class PenilaianService
{
    /**
     * Hitung nilai per komponen: (skor / 5) × bobot_persen.
     * Total = sum semua komponen (max 100).
     */
    public function hitungNilaiAkhir(array $detailRows): float
    {
        $total = 0.0;
        foreach ($detailRows as $row) {
            $skor = (int) ($row['skor'] ?? 0);
            $bobot = (int) ($row['bobot_persen'] ?? 0);
            $total += ($skor / 5) * $bobot;
        }
        return round($total, 2);
    }

    /**
     * Mapping nilai akhir ke kategori.
     */
    public function kategoriNilai(float $nilai): string
    {
        return match (true) {
            $nilai >= 85 => 'Sangat Baik',
            $nilai >= 70 => 'Baik',
            $nilai >= 55 => 'Cukup',
            $nilai >= 40 => 'Kurang',
            default      => 'Sangat Kurang',
        };
    }

    /**
     * Simpan penilaian + detail dari input form.
     * $rows: array of ['kriteria_id', 'skor', 'catatan'] dengan 'bobot_persen' di-resolve dari DB.
     */
    public function simpan(PenugasanReviewer $penugasan, array $rows, string $rekomendasi, string $catatanUmum): Penilaian
    {
        return DB::transaction(function () use ($penugasan, $rows, $rekomendasi, $catatanUmum) {
            // Hapus penilaian lama (jika revisi)
            $penugasan->penilaian()->delete();

            // Resolve bobot per kriteria dari DB (untuk security: jangan trust client-side)
            $kriteria = $penugasan->proposal->skemaHibah->kriteriaPenilaian()->get()->keyBy('id');

            // Hitung nilai akhir berdasar bobot DB (bukan input)
            $nilaiRows = [];
            foreach ($rows as $r) {
                if (! isset($kriteria[$r['kriteria_id']])) continue;
                $nilaiRows[] = [
                    'kriteria_id'  => $r['kriteria_id'],
                    'skor'         => $r['skor'],
                    'bobot_persen' => $kriteria[$r['kriteria_id']]->bobot_persen,
                    'catatan'      => $r['catatan'] ?? null,
                ];
            }

            $nilaiTotal = $this->hitungNilaiAkhir($nilaiRows);

            $penilaian = Penilaian::create([
                'penugasan_id' => $penugasan->id,
                'nilai_total'  => $nilaiTotal,
                'rekomendasi'  => $rekomendasi,
                'catatan_umum' => $catatanUmum,
                'tgl_selesai'  => now(),
            ]);

            foreach ($nilaiRows as $row) {
                PenilaianDetail::create([
                    'penilaian_id' => $penilaian->id,
                    'kriteria_id'  => $row['kriteria_id'],
                    'skor'         => $row['skor'],
                    'catatan'      => $row['catatan'],
                ]);
            }

            // Update status penugasan
            $penugasan->update(['status' => 'selesai']);

            // Update status proposal kalau semua reviewer sudah selesai
            $this->maybeUpdateProposalStatus($penugasan->proposal);

            return $penilaian;
        });
    }

    /**
     * Kalau semua reviewer sudah submit penilaian, agregasi nilai rata-rata.
     * Status proposal di-set sesuai rekomendasi mayoritas (operator yang final-decide nanti).
     */
    private function maybeUpdateProposalStatus(Proposal $proposal): void
    {
        $proposal->refresh()->load('penugasanReviewer.penilaian');

        $totalAssignments = $proposal->penugasanReviewer->count();
        if ($totalAssignments === 0) return;

        $completed = $proposal->penugasanReviewer->filter(fn($pr) => $pr->penilaian !== null)->count();

        // Tunggu sampai semua reviewer selesai
        if ($completed < $totalAssignments) return;

        // Semua reviewer sudah submit; biarkan operator yang final-decide.
        // Status tidak otomatis berubah dari 'direview' — operator perlu finalize manual.
        // Tapi kita bisa update bahwa "siap finalize" via signal lain kalau perlu.
    }

    /**
     * Hitung agregasi penilaian untuk operator finalize.
     */
    public function agregasi(Proposal $proposal): array
    {
        $proposal->load('penugasanReviewer.penilaian');

        $penilaianList = $proposal->penugasanReviewer
            ->map(fn($pr) => $pr->penilaian)
            ->filter();

        if ($penilaianList->isEmpty()) {
            return [
                'jumlah_reviewer'  => $proposal->penugasanReviewer->count(),
                'jumlah_selesai'   => 0,
                'rata_rata'        => 0,
                'kategori'         => '-',
                'rekomendasi_list' => [],
            ];
        }

        $rataRata = round($penilaianList->avg('nilai_total'), 2);

        return [
            'jumlah_reviewer'  => $proposal->penugasanReviewer->count(),
            'jumlah_selesai'   => $penilaianList->count(),
            'rata_rata'        => $rataRata,
            'kategori'         => $this->kategoriNilai($rataRata),
            'rekomendasi_list' => $penilaianList->pluck('rekomendasi')->toArray(),
        ];
    }
}
