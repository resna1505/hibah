@extends('layouts.operator')

@section('title', 'Status Proposal')

@php $activeNav = 'proposal.status'; @endphp

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
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->ketua?->fakultas?->kode }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                <td><x-status-badge :status="$p->status" tooltip /></td>
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
        <div class="card-header bg-white"><h6 class="mb-0">Legenda Status Proposal</h6></div>
        <div class="card-body">
            <p class="text-muted small mb-3"><i class="ri-information-line"></i> Hover badge di tabel atas untuk lihat penjelasan + langkah berikutnya.</p>
            <div class="row g-3">
                @foreach (['draft','submitted','verifikasi','direview','revisi_minor','revisi_mayor','dikembalikan','disetujui','berjalan','selesai','ditolak'] as $st)
                    <div class="col-md-6 col-lg-4 d-flex align-items-center gap-2">
                        <x-status-badge :status="$st" tooltip />
                        <small class="text-muted">Hover untuk detail</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
