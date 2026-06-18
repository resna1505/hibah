<?php

namespace App\Services;

use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\Proposal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        // Cek ulang syarat ketua (jaga-jaga kalau profil diubah setelah create)
        if ($proposal->ketua) {
            foreach ($this->checkKetuaEligibility($proposal->ketua) as $issue) {
                $errors[] = 'Syarat ketua: ' . $issue;
            }
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
     * Generate nomor registrasi proposal sesuai format di Pengaturan.
     * Idempotent: kalau proposal sudah punya no_registrasi, return saja.
     */
    public function generateNoRegistrasi(Proposal $proposal): string
    {
        if ($proposal->no_registrasi) return $proposal->no_registrasi;

        $kode    = \App\Models\Master\Pengaturan::get('institusi_kode', 'LPPM');
        $format  = \App\Models\Master\Pengaturan::get('proposal_no_format', '{kode}/{jenis}/{tahun}/{seq:3}');
        $jenis   = strtoupper($proposal->skemaHibah?->jenis === 'pkm' ? 'PKM' : 'PNL');
        $tahun   = $proposal->periodeHibah?->tahun ?? ($proposal->tgl_submit ? $proposal->tgl_submit->year : now()->year);

        // Hitung sequence per (jenis, tahun) berdasarkan jumlah proposal yg sudah punya no_registrasi pada periode itu
        $seqCount = Proposal::whereNotNull('no_registrasi')
            ->whereHas('skemaHibah', fn($q) => $q->where('jenis', $proposal->skemaHibah?->jenis))
            ->whereHas('periodeHibah', fn($q) => $q->where('tahun', $tahun))
            ->where('id', '!=', $proposal->id)
            ->count();
        $seq = $seqCount + 1;

        // Replace token {seq:N} dengan zero-pad N digit
        $no = preg_replace_callback('/\{seq:(\d+)\}/', fn($m) => str_pad($seq, (int) $m[1], '0', STR_PAD_LEFT), $format);
        $no = str_replace(['{kode}', '{jenis}', '{tahun}'], [$kode, $jenis, $tahun], $no);

        // Resolve collision (race condition) — append suffix bila duplikat
        $base = $no; $i = 0;
        while (Proposal::where('no_registrasi', $no)->where('id', '!=', $proposal->id)->exists()) {
            $i++;
            $no = $base . '-' . $i;
        }

        $proposal->update(['no_registrasi' => $no]);
        return $no;
    }

    /**
     * Cek kelayakan seorang dosen sebagai KETUA pengusul.
     * Return: array of error messages (kosong = eligible).
     * Syarat default: pendidikan S3 + jabatan Lektor (configurable via Pengaturan).
     */
    public function checkKetuaEligibility(\App\Models\Master\Dosen $dosen): array
    {
        $errors = [];

        // Kelayakan ketua ditentukan operator LPPM per dosen (penanda is_ketua_eligible),
        // bukan lagi ambang pendidikan/jabatan otomatis.
        if (! $dosen->is_ketua_eligible) {
            $errors[] = 'Anda belum ditetapkan sebagai dosen yang berhak menjadi ketua pengusul. Silakan hubungi operator LPPM.';
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

    /**
     * Submit ulang setelah revisi minor/mayor: kembalikan proposal langsung ke
     * reviewer yang sama untuk penilaian ulang (tanpa verifikasi & penugasan ulang).
     *
     * Penilaian lama TIDAK dihapus (dipakai untuk prefill form reviewer); cukup
     * status penugasan dibuka kembali ke 'ditugaskan'. Selama penugasan belum
     * 'selesai', PenilaianService::agregasi() tidak menghitung penilaian lama,
     * sehingga operator belum bisa finalisasi sampai reviewer menilai ulang.
     *
     * @return Collection<\App\Models\Master\Dosen> Reviewer yang perlu dinotifikasi.
     */
    public function reopenUntukPenilaianUlang(Proposal $proposal): Collection
    {
        return DB::transaction(function () use ($proposal) {
            $proposal->update([
                'status'         => 'direview',
                'tgl_submit'     => now(),
                'total_anggaran' => $this->totalRab($proposal),
            ]);

            $proposal->penugasanReviewer()->update(['status' => 'ditugaskan']);

            return $proposal->penugasanReviewer()->with('reviewer')->get()
                ->pluck('reviewer')->filter()->values();
        });
    }
}
