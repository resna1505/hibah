@extends('layouts.reviewer')

@section('title', 'Detail Proposal')

@php $activeNav = 'proposal'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detail Proposal</h4>
            <p class="text-muted small mb-0">{{ $p->skemaHibah->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('reviewer.proposal.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
            @if ($myPenugasan)
                <a href="{{ route('reviewer.proposal.pdf', $p) }}" class="btn btn-sm btn-outline-secondary"><i class="ri-download-line"></i> Unduh PDF</a>
            @endif
            @if ($myPenugasan && in_array($myPenugasan->status, ['ditugaskan', 'sedang_review']))
                <a href="{{ route('reviewer.penilaian.form', $myPenugasan) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i> Nilai Proposal</a>
            @elseif ($myPenugasan?->status === 'selesai')
                <a href="{{ route('reviewer.hasil.show', $myPenugasan) }}" class="btn btn-sm btn-success"><i class="ri-file-text-line"></i> Lihat Hasil</a>
            @endif
        </div>
    </div>

    @if (! $myPenugasan)
        <div class="alert alert-info"><i class="ri-information-line me-1"></i> Anda tidak ditugaskan untuk proposal ini, hanya bisa melihat detail (read-only).</div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="mb-2">{{ $p->judul }}</h5>
                    <table class="table table-sm mb-0">
                        @if ($p->no_registrasi)
                            <tr><td width="30%" class="text-muted small">No. Registrasi</td><td><code>{{ $p->no_registrasi }}</code></td></tr>
                        @endif
                        <tr><td width="30%" class="text-muted small">Ketua</td><td>{{ $p->ketua->nama_lengkap }}</td></tr>
                        <tr><td class="text-muted small">Fakultas / Prodi</td><td>{{ $p->ketua->fakultas?->nama }} / {{ $p->ketua->prodi?->nama }}</td></tr>
                        <tr><td class="text-muted small">Skema</td><td>{{ $p->skemaHibah->nama }}</td></tr>
                        @if ($p->bidangStrategis)
                            <tr><td class="text-muted small">Bidang Strategis</td><td>{{ $p->bidangStrategis->kode }}. {{ $p->bidangStrategis->nama }}</td></tr>
                        @endif
                        <tr><td class="text-muted small">Total Anggaran</td><td>Rp {{ number_format($totalRab, 0, ',', '.') }}</td></tr>
                        <tr><td class="text-muted small">Durasi</td><td>{{ $p->durasi_bulan }} bulan</td></tr>
                    </table>
                </div>
            </div>

            @if ($p->bidangStrategis && ($p->rumusan_masalah_bidang || $p->uraian_bidang))
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Bidang Strategis</h6></div>
                    <div class="card-body small">
                        @if ($p->rumusan_masalah_bidang)<p class="mb-1"><span class="text-muted">Rumusan Masalah:</span><br>{{ $p->rumusan_masalah_bidang }}</p>@endif
                        @if ($p->uraian_bidang)<p class="mb-0"><span class="text-muted">Uraian:</span><br>{{ $p->uraian_bidang }}</p>@endif
                    </div>
                </div>
            @endif

            @if ($p->ringkasan)<div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white"><h6 class="mb-0">Ringkasan</h6></div><div class="card-body"><p class="small mb-0">{{ $p->ringkasan }}</p></div></div>@endif
            @if ($p->pendahuluan)<div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white"><h6 class="mb-0">Pendahuluan</h6></div><div class="card-body"><p class="small mb-0" style="white-space:pre-wrap;">{{ $p->pendahuluan }}</p></div></div>@endif
            @if ($p->permasalahan_solusi)<div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white"><h6 class="mb-0">Permasalahan & Solusi</h6></div><div class="card-body"><p class="small mb-0" style="white-space:pre-wrap;">{{ $p->permasalahan_solusi }}</p></div></div>@endif
            @if ($p->metode)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Metode</h6></div>
                    <div class="card-body">
                        <p class="small" style="white-space:pre-wrap;">{{ $p->metode }}</p>
                        @if ($p->metode_diagram_path)<img src="{{ asset('storage/' . $p->metode_diagram_path) }}" class="img-fluid border rounded mt-2" style="max-height:300px;">@endif
                    </div>
                </div>
            @endif
            @if ($p->daftar_pustaka)<div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white"><h6 class="mb-0">Daftar Pustaka</h6></div><div class="card-body"><p class="small mb-0" style="white-space:pre-wrap;">{{ $p->daftar_pustaka }}</p></div></div>@endif
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
                                <strong>Mahasiswa:</strong><br>{{ $a->nama_mahasiswa }}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($p->mitra->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Mitra</h6></div>
                    <div class="card-body small">
                        @foreach ($p->mitra as $m)<div class="mb-2 pb-2 border-bottom"><strong>{{ $m->nama_mitra }}</strong></div>@endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-12">
            @if ($p->rencanaLuaran->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Rencana Luaran</h6></div>
                    <div class="card-body p-0">
                        <table class="table mb-0 small">
                            <thead class="table-light"><tr><th width="80">Tahun ke-</th><th width="100">Kategori</th><th>Jenis Luaran</th><th>Status Target</th><th>Keterangan</th></tr></thead>
                            <tbody>
                                @foreach ($p->rencanaLuaran as $rl)
                                    <tr>
                                        <td>{{ $rl->tahun_ke }}</td>
                                        <td>{{ ucfirst($rl->kategori) }}</td>
                                        <td>{{ $rl->jenisLuaran?->nama ?? $rl->jenis_luaran_text ?? '-' }}</td>
                                        <td>{{ $rl->status_target ?? '-' }}</td>
                                        <td class="text-muted">{{ $rl->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if ($p->dokumen->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Dokumen Pendukung</h6></div>
                    <div class="card-body p-0">
                        <table class="table mb-0 small">
                            <thead class="table-light"><tr><th width="220">Jenis</th><th>Nama File</th><th width="120">Ukuran</th></tr></thead>
                            <tbody>
                                @foreach ($p->dokumen as $d)
                                    <tr>
                                        <td><span class="badge bg-secondary-subtle text-dark">{{ $d->jenis }}</span></td>
                                        <td><a href="{{ asset('storage/' . $d->path) }}" target="_blank">{{ $d->nama_file }}</a></td>
                                        <td class="text-muted">{{ number_format($d->ukuran / 1024, 1) }} KB</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between"><h6 class="mb-0">RAB</h6><strong class="text-primary">Total: Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></div>
                <div class="card-body p-0">
                    <table class="table mb-0 small">
                        <thead class="table-light"><tr><th>Kelompok</th><th>Komponen</th><th>Item</th><th>Justifikasi</th><th class="text-end">Qty</th><th class="text-end">Harga</th><th class="text-end">Sub Total</th></tr></thead>
                        <tbody>
                            @forelse ($p->rab as $r)
                                <tr><td>{{ $r->kategori?->nama }}</td><td class="text-muted"><em>{{ $r->komponen?->nama ?? '-' }}</em></td><td>{{ $r->item }}</td><td class="text-muted">{{ $r->justifikasi }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }} {{ $r->satuan }}</td>
                                    <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td></tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-3">RAB belum diisi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
