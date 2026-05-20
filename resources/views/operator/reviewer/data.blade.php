@extends('layouts.operator')

@section('title', 'Data Reviewer')

@php $activeNav = 'reviewer.data'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Data Reviewer</h4>
            <p class="text-muted small mb-0">Aktifkan / nonaktifkan dosen sebagai reviewer</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Cari Nama Dosen</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ $filters['search'] ?? '' }}">
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
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="filter" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="reviewer" @selected(($filters['filter'] ?? null) === 'reviewer')>Reviewer Aktif</option>
                        <option value="nonreviewer" @selected(($filters['filter'] ?? null) === 'nonreviewer')>Bukan Reviewer</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.reviewer.data') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIDN</th>
                            <th>Fakultas</th>
                            <th>Keahlian</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $d)
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td class="small">{{ $d->nidn ?? '-' }}</td>
                                <td class="small">{{ $d->fakultas?->kode }}</td>
                                <td class="small">
                                    @foreach ($d->keahlian->take(3) as $k)
                                        <span class="badge bg-light text-dark me-1">{{ $k->nama }}</span>
                                    @endforeach
                                    @if ($d->keahlian->count() > 3)
                                        <span class="text-muted">+{{ $d->keahlian->count() - 3 }}</span>
                                    @endif
                                </td>
                                <td class="small">{{ $d->jabatan_fungsional ?? '-' }}</td>
                                <td>
                                    @if ($d->is_reviewer)
                                        <span class="badge bg-success-subtle text-success">Reviewer Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Bukan Reviewer</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('operator.reviewer.toggle', $d) }}" class="d-inline"
                                        onsubmit="return confirm('Ubah status reviewer untuk {{ $d->nama_lengkap }}?');">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $d->is_reviewer ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            <i class="ri-toggle-line"></i> {{ $d->is_reviewer ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada dosen ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
