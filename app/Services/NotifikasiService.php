<?php

namespace App\Services;

use App\Models\Master\Dosen;
use App\Models\Transaction\Notifikasi;
use App\Models\Transaction\Proposal;
use App\Models\User;

class NotifikasiService
{
    /**
     * Generic create notif.
     */
    public function notify(int $userId, string $judul, string $pesan, ?string $link = null, ?string $icon = null): Notifikasi
    {
        return Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'link'    => $link,
            'icon'    => $icon,
        ]);
    }

    /**
     * Notify semua operator.
     */
    public function notifyOperators(string $judul, string $pesan, ?string $link = null, ?string $icon = null): void
    {
        $operators = User::where('role', 'operator')->where('is_active', true)->pluck('id');
        foreach ($operators as $uid) {
            $this->notify($uid, $judul, $pesan, $link, $icon);
        }
    }

    // ============================================================
    // EVENT HOOKS
    // ============================================================

    /**
     * Dosen submit proposal → notify operator.
     */
    public function onProposalSubmitted(Proposal $proposal): void
    {
        $jenis = $proposal->skemaHibah?->jenis === 'pkm' ? 'PKM' : 'Penelitian';
        $this->notifyOperators(
            judul: "Proposal {$jenis} baru masuk",
            pesan: "{$proposal->ketua?->nama_lengkap} mengajukan: {$proposal->judul}",
            link:  route('operator.proposal.show', $proposal),
            icon:  'ri-file-text-line',
        );
    }

    /**
     * Operator verifikasi proposal → notify dosen ketua.
     */
    public function onProposalVerified(Proposal $proposal, string $keputusan, string $catatan): void
    {
        $userId = $proposal->ketua?->user_id;
        if (! $userId) return;

        $label = match ($keputusan) {
            'lengkap'      => 'lolos verifikasi dan akan masuk tahap review',
            'dikembalikan' => 'dikembalikan untuk diperbaiki',
            'ditolak'      => 'ditolak pada tahap verifikasi',
            default        => $keputusan,
        };

        $route = $proposal->skemaHibah?->jenis === 'pkm' ? 'dosen.pkm.show' : 'dosen.penelitian.show';

        $this->notify(
            userId: $userId,
            judul: "Verifikasi proposal",
            pesan: "Proposal '{$proposal->judul}' {$label}. " . ($catatan ? "Catatan: " . substr($catatan, 0, 100) : ''),
            link:  route($route, $proposal),
            icon:  'ri-checkbox-circle-line',
        );
    }

    /**
     * Reviewer ditugaskan → notify reviewer.
     */
    public function onReviewerAssigned(Proposal $proposal, Dosen $reviewer, string $peran, string $deadline): void
    {
        $userId = $reviewer->user_id;
        if (! $userId) return;

        $peranLabel = ucfirst(str_replace('reviewer_', 'Reviewer ', $peran));
        $this->notify(
            userId: $userId,
            judul: "Penugasan {$peranLabel}",
            pesan: "Anda ditugaskan menilai: {$proposal->judul}. Deadline: {$deadline}",
            link:  route('reviewer.proposal.index'),
            icon:  'ri-user-star-line',
        );
    }

    /**
     * Reviewer submit penilaian → notify operator.
     */
    public function onPenilaianSubmitted(Proposal $proposal, Dosen $reviewer, float $nilai): void
    {
        $this->notifyOperators(
            judul: "Penilaian reviewer masuk",
            pesan: "{$reviewer->nama_lengkap} menyelesaikan penilaian '{$proposal->judul}' dengan nilai " . number_format($nilai, 2),
            link:  route('operator.penilaian.show', $proposal),
            icon:  'ri-clipboard-line',
        );
    }

    /**
     * Operator finalize → notify dosen.
     */
    public function onProposalFinalized(Proposal $proposal, string $keputusan): void
    {
        $userId = $proposal->ketua?->user_id;
        if (! $userId) return;

        $label = match ($keputusan) {
            'disetujui'    => '🎉 DISETUJUI untuk didanai',
            'revisi_minor' => 'memerlukan REVISI MINOR',
            'revisi_mayor' => 'memerlukan REVISI MAYOR',
            'ditolak'      => 'DITOLAK',
            default        => $keputusan,
        };

        $route = $proposal->skemaHibah?->jenis === 'pkm' ? 'dosen.pkm.show' : 'dosen.penelitian.show';

        $this->notify(
            userId: $userId,
            judul: "Keputusan Final Hibah",
            pesan: "Proposal '{$proposal->judul}' {$label}",
            link:  route($route, $proposal),
            icon:  'ri-trophy-line',
        );
    }

    /**
     * Dosen upload laporan → notify operator.
     */
    public function onLaporanUploaded(Proposal $proposal, string $jenis): void
    {
        $this->notifyOperators(
            judul: "Laporan {$jenis} diunggah",
            pesan: "{$proposal->ketua?->nama_lengkap} mengunggah laporan {$jenis} untuk: {$proposal->judul}",
            link:  route('operator.laporan.show', $proposal),
            icon:  'ri-upload-line',
        );
    }

    /**
     * Operator verifikasi laporan → notify dosen.
     */
    public function onLaporanVerified(Proposal $proposal, string $jenis, string $status): void
    {
        $userId = $proposal->ketua?->user_id;
        if (! $userId) return;

        $label = $status === 'terverifikasi' ? 'TERVERIFIKASI ✓' : 'DITOLAK ✗';
        $route = $proposal->skemaHibah?->jenis === 'pkm' ? 'dosen.pkm.show' : 'dosen.penelitian.show';

        $this->notify(
            userId: $userId,
            judul: "Verifikasi Laporan {$jenis}",
            pesan: "Laporan {$jenis} untuk '{$proposal->judul}' {$label}",
            link:  route('dosen.laporan.show', $proposal),
            icon:  $status === 'terverifikasi' ? 'ri-checkbox-circle-line' : 'ri-close-circle-line',
        );
    }
}
