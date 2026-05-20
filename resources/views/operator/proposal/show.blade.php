@extends('layouts.operator')

@section('title', 'Detail Proposal')

@php
    $activeNav = 'proposal.data';

    $statusBadge = [
        'draft' => ['Draft', 'bg-secondary-subtle text-secondary'],
        'submitted' => ['Menunggu Verifikasi', 'bg-info-subtle text-info'],
        'verifikasi' => ['Terverifikasi', 'bg-info-subtle text-info'],
        'dikembalikan' => ['Dikembalikan', 'bg-warning-subtle text-warning'],
        'direview' => ['Sedang Direview', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'disetujui' => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak' => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan' => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai' => ['Selesai', 'bg-success-subtle text-success'],
    ];
    [$label, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detail Proposal</h4>
            <p class="text-muted small mb-0">{{ $p->skemaHibah->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('operator.proposal.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
            @if (in_array($p->status, ['submitted', 'verifikasi', 'dikembalikan']))
                <a href="{{ route('operator.proposal.verifikasi', $p) }}" class="btn btn-sm btn-warning"><i class="ri-checkbox-circle-line"></i> Verifikasi</a>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="mb-0">{{ $p->judul }}</h5>
                        <span class="badge {{ $cls }} fs-6">{{ $label }}</span>
                    </div>
                    <table class="table table-sm mb-0">
                        <tr><td width="30%" class="text-muted small">Ketua Peneliti</td><td>{{ $p->ketua->nama_lengkap }} ({{ $p->ketua->nidn ?? '-' }})</td></tr>
                        <tr><td class="text-muted small">Fakultas / Prodi</td><td>{{ $p->ketua->fakultas?->nama }} / {{ $p->ketua->prodi?->nama }}</td></tr>
                        <tr><td class="text-muted small">Skema</td><td>{{ $p->skemaHibah->nama }}</td></tr>
                        <tr><td class="text-muted small">Periode</td><td>{{ $p->periodeHibah->nama }}</td></tr>
                        <tr><td class="text-muted small">Durasi</td><td>{{ $p->durasi_bulan }} bulan</td></tr>
                        <tr><td class="text-muted small">Total Anggaran</td><td><strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></td></tr>
                        <tr><td class="text-muted small">Tgl Submit</td><td>{{ $p->tgl_submit?->format('d M Y H:i') ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            @if ($p->ringkasan)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Ringkasan</h6></div>
                    <div class="card-body"><p class="small mb-0">{{ $p->ringkasan }}</p></div>
                </div>
            @endif
            @if ($p->pendahuluan)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Pendahuluan</h6></div>
                    <div class="card-body"><p class="small mb-0" style="white-space:pre-wrap;">{{ $p->pendahuluan }}</p></div>
                </div>
            @endif
            @if ($p->permasalahan_solusi)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Permasalahan & Solusi</h6></div>
                    <div class="card-body"><p class="small mb-0" style="white-space:pre-wrap;">{{ $p->permasalahan_solusi }}</p></div>
                </div>
            @endif
            @if ($p->metode)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Metode</h6></div>
                    <div class="card-body">
                        <p class="small" style="white-space:pre-wrap;">{{ $p->metode }}</p>
                        @if ($p->metode_diagram_path)
                            <img src="{{ asset('storage/' . $p->metode_diagram_path) }}" class="img-fluid border rounded mt-2" style="max-height:300px;">
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0">Tim Pengusul</h6></div>
                <div class="card-body small">
                    <p class="mb-1"><strong>Ketua:</strong><br>{{ $p->ketua->nama_lengkap }}</p>
                    @foreach ($p->anggota as $a)
                        <div class="border-top pt-2 mt-2">
                            @if ($a->peran === 'anggota_dosen')
                                <strong>Anggota Dosen:</strong><br>{{ $a->dosen?->nama_lengkap }}
                            @else
                                <strong>Mahasiswa:</strong><br>{{ $a->nama_mahasiswa }} ({{ $a->nim }})
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($p->mitra->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Mitra</h6></div>
                    <div class="card-body small">
                        @foreach ($p->mitra as $m)
                            <div class="mb-2 pb-2 border-bottom">
                                <strong>{{ $m->nama_mitra }}</strong> &mdash; {{ $m->pimpinan_mitra }}<br>
                                <span class="text-muted">{{ $m->alamat_mitra }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Riwayat Verifikasi --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0">Riwayat Verifikasi</h6></div>
                <div class="card-body p-0">
                    @forelse ($p->verifikasi->sortByDesc('id') as $v)
                        <div class="px-3 py-2 border-bottom small">
                            <div class="d-flex justify-content-between">
                                <strong>{{ ucfirst($v->status) }}</strong>
                                <span class="text-muted">{{ $v->tgl_verifikasi->format('d M Y H:i') }}</span>
                            </div>
                            @if ($v->catatan)<p class="text-muted mb-0 mt-1">{{ $v->catatan }}</p>@endif
                            <small class="text-muted">oleh {{ $v->operator?->username ?? '-' }}</small>
                        </div>
                    @empty
                        <p class="px-3 py-3 text-muted small mb-0">Belum ada riwayat verifikasi.</p>
                    @endforelse
                </div>
            </div>

            {{-- Reviewer Assignment --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0">Reviewer Ditugaskan</h6></div>
                <div class="card-body small">
                    @forelse ($p->penugasanReviewer as $pr)
                        <div class="mb-2">
                            <strong>{{ str_replace('reviewer_', 'Reviewer ', $pr->peran) }}:</strong>
                            {{ $pr->reviewer?->nama_lengkap }}<br>
                            <span class="text-muted">Deadline: {{ $pr->deadline->format('d M Y') }} &middot; Status: {{ $pr->status }}</span>
                            @if ($pr->penilaian)
                                <br><span class="text-success">Nilai: {{ $pr->penilaian->nilai_total }} &mdash; {{ ucfirst(str_replace('_', ' ', $pr->penilaian->rekomendasi)) }}</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada reviewer ditugaskan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between"><h6 class="mb-0">RAB</h6><strong class="text-primary">Total: Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></div>
                <div class="card-body p-0">
                    <table class="table mb-0 small">
                        <thead class="table-light"><tr><th>Kategori</th><th>Item</th><th>Justifikasi</th><th class="text-end">Qty</th><th class="text-end">Harga</th><th class="text-end">Sub Total</th></tr></thead>
                        <tbody>
                            @forelse ($p->rab as $r)
                                <tr>
                                    <td>{{ $r->kategori?->nama }}</td>
                                    <td>{{ $r->item }}</td>
                                    <td class="text-muted">{{ $r->justifikasi }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }} {{ $r->satuan }}</td>
                                    <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">RAB belum diisi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
