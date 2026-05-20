@extends('layouts.operator')

@section('title', 'Status Proposal')

@php
    $activeNav = 'proposal.status';

    $statusBadge = [
        'draft'        => ['Draft', 'bg-secondary-subtle text-secondary'],
        'submitted'    => ['Menunggu Verifikasi', 'bg-info-subtle text-info'],
        'verifikasi'   => ['Dalam Proses', 'bg-info-subtle text-info'],
        'dikembalikan' => ['Dalam Proses', 'bg-warning-subtle text-warning'],
        'direview'     => ['Dalam Proses', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Dalam Proses', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Dalam Proses', 'bg-warning-subtle text-warning'],
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan'     => ['Disetujui', 'bg-success-subtle text-success'],
        'selesai'      => ['Disetujui', 'bg-success-subtle text-success'],
        'ditarik'      => ['Ditarik', 'bg-secondary-subtle text-secondary'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Status Proposal</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }}</p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
            <div class="bg-primary-subtle rounded-3 p-2 me-3"><i class="ri-file-text-line fs-3 text-primary"></i></div>
            <div><p class="text-muted small mb-0">Total Proposal</p><h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4></div>
        </div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
            <div class="bg-success-subtle rounded-3 p-2 me-3"><i class="ri-checkbox-circle-line fs-3 text-success"></i></div>
            <div><p class="text-muted small mb-0">Disetujui</p><h4 class="text-success mb-0">{{ $stats['disetujui'] ?? 0 }}</h4></div>
        </div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
            <div class="bg-warning-subtle rounded-3 p-2 me-3"><i class="ri-time-line fs-3 text-warning"></i></div>
            <div><p class="text-muted small mb-0">Dalam Proses</p><h4 class="text-warning mb-0">{{ $stats['dalam_proses'] ?? 0 }}</h4></div>
        </div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body d-flex align-items-center">
            <div class="bg-danger-subtle rounded-3 p-2 me-3"><i class="ri-close-circle-line fs-3 text-danger"></i></div>
            <div><p class="text-muted small mb-0">Ditolak</p><h4 class="text-danger mb-0">{{ $stats['ditolak'] ?? 0 }}</h4></div>
        </div></div></div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach (['submitted', 'verifikasi', 'direview', 'revisi_minor', 'revisi_mayor', 'disetujui', 'ditolak', 'berjalan', 'selesai', 'ditarik'] as $st)
                            <option value="{{ $st }}" @selected(($filters['status'] ?? null) === $st)>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Skema</label>
                    <select name="skema_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        @foreach ($skemaList as $s)
                            <option value="{{ $s->id }}" @selected(($filters['skema_id'] ?? null) == $s->id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Fakultas</label>
                    <select name="fakultas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        @foreach ($fakultasList as $f)
                            <option value="{{ $f->id }}" @selected(($filters['fakultas_id'] ?? null) == $f->id)>{{ $f->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('operator.proposal.status') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i> Reset Filter</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><h6 class="mb-0">Daftar Proposal</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>No</th><th>Judul</th><th>Ketua</th><th>Fakultas</th><th>Skema</th><th>Tgl Submit</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php [$lbl, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted']; @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->ketua?->fakultas?->kode }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="text-end"><a href="{{ route('operator.proposal.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i> Detail</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada proposal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-white"><h6 class="mb-0">Keterangan Status</h6></div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col">
                    <span class="badge bg-success-subtle text-success mb-2 fs-6">Disetujui</span>
                    <p class="text-muted small mb-0">Proposal dinyatakan lolos dan disetujui untuk didanai.</p>
                </div>
                <div class="col">
                    <span class="badge bg-warning-subtle text-warning mb-2 fs-6">Dalam Proses</span>
                    <p class="text-muted small mb-0">Proposal sedang dalam proses review atau verifikasi.</p>
                </div>
                <div class="col">
                    <span class="badge bg-danger-subtle text-danger mb-2 fs-6">Ditolak</span>
                    <p class="text-muted small mb-0">Proposal dinyatakan tidak lolos atau ditolak.</p>
                </div>
                <div class="col">
                    <span class="badge bg-secondary-subtle text-secondary mb-2 fs-6">Ditarik</span>
                    <p class="text-muted small mb-0">Proposal ditarik oleh pengusul sebelum proses selesai.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
