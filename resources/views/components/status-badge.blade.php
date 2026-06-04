{{--
    Single source of truth untuk label & badge status proposal.
    Usage:
        <x-status-badge :status="$p->status" />                 badge biasa
        <x-status-badge :status="$p->status" tooltip />         badge + tooltip deskripsi & next step
        <x-status-badge :status="$p->status" tooltip large />   ukuran lebih besar
--}}

@props([
    'status'  => '',
    'tooltip' => false,
    'large'   => false,
])

@php
    $map = [
        'draft' => [
            'label'       => 'Draft',
            'class'       => 'bg-secondary-subtle text-secondary',
            'description' => 'Belum di-submit oleh pengusul.',
            'next'        => 'Pengusul lengkapi semua bagian lalu klik Submit.',
        ],
        'submitted' => [
            'label'       => 'Menunggu Verifikasi',
            'class'       => 'bg-info-subtle text-info',
            'description' => 'Sudah di-submit, menunggu verifikasi administratif LPPM.',
            'next'        => 'Operator verifikasi → Terima atau Kembalikan.',
        ],
        'verifikasi' => [
            'label'       => 'Verifikasi Diterima',
            'class'       => 'bg-info-subtle text-info',
            'description' => 'Verifikasi administratif lolos, siap ditugaskan reviewer.',
            'next'        => 'Operator assign reviewer di menu Penugasan Reviewer.',
        ],
        'dikembalikan' => [
            'label'       => 'Dikembalikan',
            'class'       => 'bg-warning-subtle text-warning',
            'description' => 'Dikembalikan ke dosen dengan catatan perbaikan.',
            'next'        => 'Dosen perbaiki sesuai catatan lalu submit ulang.',
        ],
        'direview' => [
            'label'       => 'Sedang Direview',
            'class'       => 'bg-info-subtle text-info',
            'description' => 'Reviewer sedang menilai proposal.',
            'next'        => 'Tunggu semua reviewer selesai, lalu operator Finalize keputusan.',
        ],
        'revisi_minor' => [
            'label'       => 'Revisi Minor',
            'class'       => 'bg-warning-subtle text-warning',
            'description' => 'Reviewer minta revisi ringan.',
            'next'        => 'Dosen perbaiki lalu submit revisi.',
        ],
        'revisi_mayor' => [
            'label'       => 'Revisi Mayor',
            'class'       => 'bg-warning-subtle text-warning',
            'description' => 'Reviewer minta revisi besar.',
            'next'        => 'Dosen perbaiki substansial lalu submit revisi.',
        ],
        'disetujui' => [
            'label'       => 'Disetujui',
            'class'       => 'bg-success-subtle text-success',
            'description' => 'Proposal disetujui untuk didanai.',
            'next'        => 'Dosen mulai pelaksanaan + upload laporan kemajuan/akhir.',
        ],
        'ditolak' => [
            'label'       => 'Ditolak',
            'class'       => 'bg-danger-subtle text-danger',
            'description' => 'Tidak lolos seleksi LPPM.',
            'next'        => 'Akhir alur. Dosen bisa ajukan lagi di periode berikutnya.',
        ],
        'berjalan' => [
            'label'       => 'Berjalan',
            'class'       => 'bg-primary-subtle text-primary',
            'description' => 'Pelaksanaan kegiatan sedang berjalan.',
            'next'        => 'Dosen upload laporan kemajuan + akhir + luaran.',
        ],
        'selesai' => [
            'label'       => 'Selesai',
            'class'       => 'bg-success-subtle text-success',
            'description' => 'Semua tahap selesai, laporan akhir terverifikasi.',
            'next'        => 'Tidak ada aksi. Arsipkan sebagai histori.',
        ],
        'ditarik' => [
            'label'       => 'Ditarik',
            'class'       => 'bg-secondary-subtle text-secondary',
            'description' => 'Ditarik oleh pengusul sebelum proses selesai.',
            'next'        => 'Tidak ada aksi.',
        ],
    ];

    $info  = $map[$status] ?? ['label' => $status, 'class' => 'bg-light text-muted', 'description' => '', 'next' => ''];
    $sizeClass = $large ? 'fs-6' : '';
    $tooltipTitle = $tooltip ? "<strong>{$info['description']}</strong><br><em>Berikutnya:</em> {$info['next']}" : null;
@endphp

<span
    class="badge {{ $info['class'] }} {{ $sizeClass }}"
    @if ($tooltip && ($info['description'] || $info['next']))
        data-bs-toggle="tooltip"
        data-bs-html="true"
        data-bs-placement="top"
        title="{!! $tooltipTitle !!}"
        style="cursor: help;"
    @endif
>{{ $info['label'] }}</span>
