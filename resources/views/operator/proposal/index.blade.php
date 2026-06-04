@extends('layouts.operator')

@section('title', 'Proposal Hibah')

@php $activeNav = 'proposal.data'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Proposal Hibah</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }}</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Total</p><h4 class="mb-0 text-primary">{{ $stats['total'] ?? 0 }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Menunggu Verifikasi</p><h4 class="mb-0 text-info">{{ $stats['submitted'] ?? 0 }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Disetujui</p><h4 class="mb-0 text-success">{{ $stats['disetujui'] ?? 0 }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Ditolak</p><h4 class="mb-0 text-danger">{{ $stats['ditolak'] ?? 0 }}</h4></div></div></div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Cari Judul / Ketua</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach (['submitted', 'verifikasi', 'dikembalikan', 'direview', 'revisi_minor', 'revisi_mayor', 'disetujui', 'ditolak'] as $st)
                            <option value="{{ $st }}" @selected(($filters['status'] ?? null) === $st)>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Skema</label>
                    <select name="skema_id" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach ($skemaList as $s)
                            <option value="{{ $s->id }}" @selected(($filters['skema_id'] ?? null) == $s->id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Fakultas</label>
                    <select name="fakultas_id" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach ($fakultasList as $f)
                            <option value="{{ $f->id }}" @selected(($filters['fakultas_id'] ?? null) == $f->id)>{{ $f->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.proposal.index') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Ketua</th>
                            <th>Fakultas</th>
                            <th>Skema</th>
                            <th>Tgl Submit</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:260px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->ketua?->fakultas?->kode }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                <td><x-status-badge :status="$p->status" tooltip /></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('operator.proposal.show', $p) }}" class="btn btn-outline-primary"><i class="ri-eye-line"></i> Lihat</a>
                                        @if (in_array($p->status, ['submitted', 'verifikasi', 'dikembalikan']))
                                            <a href="{{ route('operator.proposal.verifikasi', $p) }}" class="btn btn-warning"><i class="ri-checkbox-circle-line"></i> Verifikasi</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada proposal ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
