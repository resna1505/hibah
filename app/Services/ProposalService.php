<?php

namespace App\Services;

use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;

class ProposalService
{
    /**
     * Hitung kata dalam teks (strip tag, normalize whitespace).
     */
    public function wordCount(?string $text): int
    {
        if (! $text) return 0;
        $clean = trim(strip_tags($text));
        if ($clean === '') return 0;
        return count(preg_split('/\s+/', $clean));
    }

    /**
     * Kalkulasi total RAB.
     */
    public function totalRab(Proposal $proposal): int
    {
        return (int) $proposal->rab()->sum('sub_total');
    }

    /**
     * Validasi siap untuk submit. Return array kesalahan (kosong = OK).
     */
    public function validateForSubmit(Proposal $proposal): array
    {
        $errors = [];

        $required = ['judul', 'ringkasan', 'kata_kunci', 'pendahuluan', 'metode', 'daftar_pustaka'];
        foreach ($required as $field) {
            if (empty($proposal->$field)) {
                $errors[] = "Bagian " . str_replace('_', ' ', $field) . " belum diisi.";
            }
        }

        if ($this->wordCount($proposal->ringkasan) > 300) {
            $errors[] = 'Ringkasan melebihi 300 kata.';
        }
        if ($this->wordCount($proposal->pendahuluan) > 1000) {
            $errors[] = 'Pendahuluan melebihi 1000 kata.';
        }
        if ($this->wordCount($proposal->metode) > 1500) {
            $errors[] = 'Metode melebihi 1500 kata.';
        }

        $totalRab = $this->totalRab($proposal);
        if ($totalRab <= 0) {
            $errors[] = 'RAB belum diisi.';
        } elseif ($proposal->skemaHibah && $totalRab > $proposal->skemaHibah->max_anggaran) {
            $errors[] = 'Total RAB (Rp ' . number_format($totalRab, 0, ',', '.')
                . ') melebihi maksimum skema (Rp ' . number_format($proposal->skemaHibah->max_anggaran, 0, ',', '.') . ').';
        }

        if (! $proposal->pernyataan_setuju) {
            $errors[] = 'Anda belum menyetujui pernyataan submit.';
        }

        // PKM-only: wajib mitra
        if ($proposal->skemaHibah?->jenis === 'pkm' && $proposal->mitra()->count() === 0) {
            $errors[] = 'Data mitra wajib diisi untuk skema PKM.';
        }

        // Wajib bidang strategis
        if (! $proposal->bidang_strategis_id) {
            $errors[] = 'Bidang Strategis belum dipilih.';
        }

        // Wajib minimal 1 rencana luaran kategori "wajib"
        $luaranWajib = $proposal->rencanaLuaran()
            ->where('kategori', 'wajib')
            ->where(function ($q) {
                $q->whereNotNull('jenis_luaran_id')
                  ->orWhere(function ($qq) { $qq->whereNotNull('jenis_luaran_text')->where('jenis_luaran_text', '!=', ''); });
            })
            ->count();
        if ($luaranWajib < 1) {
            $errors[] = 'Minimal 1 Rencana Luaran kategori Wajib harus diisi.';
        }

        // Wajib setiap RAB row punya komponen
        $rabTanpaKomponen = $proposal->rab()->whereNull('komponen_rab_id')->count();
        if ($rabTanpaKomponen > 0) {
            $errors[] = "Ada {$rabTanpaKomponen} baris RAB yang belum memilih Komponen.";
        }

        return $errors;
    }

    /**
     * Cek apakah tahapan pengajuan masih berjalan.
     */
    public function tahapanPengajuanAktif(): bool
    {
        $periode = PeriodeHibah::aktif()->first();
        if (! $periode) return false;

        return $periode->jadwalTahapan()
            ->whereHas('tahapanHibah', fn($q) => $q->where('kode', 'pengajuan'))
            ->where('status', 'berjalan')
            ->exists();
    }
}
