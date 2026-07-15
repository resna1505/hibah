@extends('layouts.operator')

@section('title', 'Master Program Studi')

@php $activeNav = 'master.prodi'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Master Program Studi</h4>
            <p class="text-muted small mb-0">Kelola daftar program studi (per fakultas) yang dipakai di profil dosen & proposal.</p>
        </div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mTambah">
            <i class="ri-add-line"></i> Tambah Program Studi
        </button>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger small">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Cari Nama / Kode</label>
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
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.master.prodi.index') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="100">Kode</th>
                            <th>Nama Program Studi</th>
                            <th width="200">Fakultas</th>
                            <th width="90">Jenjang</th>
                            <th width="100">Status</th>
                            <th width="110">Dipakai</th>
                            <th width="110"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $p)
                            <tr>
                                <td><code>{{ $p->kode }}</code></td>
                                <td><strong>{{ $p->nama }}</strong></td>
                                <td class="small">{{ $p->fakultas?->nama ?? '-' }}</td>
                                <td><span class="badge bg-light text-dark">{{ $p->jenjang }}</span></td>
                                <td>
                                    @if ($p->is_active)
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="small">
                                    @if (($usage[$p->id] ?? 0) > 0)
                                        <span class="badge bg-info-subtle text-info">{{ $usage[$p->id] }} dosen</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEdit{{ $p->id }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form method="POST" action="{{ route('operator.master.prodi.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus program studi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus" {{ ($usage[$p->id] ?? 0) > 0 ? 'disabled' : '' }}>
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit per row --}}
                            <div class="modal fade" id="mEdit{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('operator.master.prodi.update', $p) }}" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header"><h6 class="modal-title">Edit Program Studi</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="form-label">Kode</label>
                                                    <input type="text" name="kode" class="form-control" value="{{ $p->kode }}" required maxlength="20">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Nama Program Studi</label>
                                                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required maxlength="150">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Fakultas</label>
                                                    <select name="fakultas_id" class="form-select" required>
                                                        @foreach ($fakultasList as $f)
                                                            <option value="{{ $f->id }}" @selected($p->fakultas_id == $f->id)>{{ $f->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Jenjang</label>
                                                    <select name="jenjang" class="form-select" required>
                                                        @foreach ($jenjangOpsi as $j)
                                                            <option value="{{ $j }}" @selected($p->jenjang === $j)>{{ $j }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_active" value="1" id="aktif{{ $p->id }}" class="form-check-input" @checked($p->is_active)>
                                                        <label for="aktif{{ $p->id }}" class="form-check-label small">Aktif <span class="text-muted">(tidak aktif = tidak muncul di pilihan prodi)</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada program studi. Tambah lewat tombol di atas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="mTambah" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operator.master.prodi.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Program Studi</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" required maxlength="20" value="{{ old('kode') }}" placeholder="Contoh: SI">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required maxlength="150" value="{{ old('nama') }}" placeholder="Contoh: Sistem Informasi">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas_id" class="form-select" required>
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultasList as $f)
                                    <option value="{{ $f->id }}" @selected(old('fakultas_id') == $f->id)>{{ $f->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenjang <span class="text-danger">*</span></label>
                            <select name="jenjang" class="form-select" required>
                                @foreach ($jenjangOpsi as $j)
                                    <option value="{{ $j }}" @selected(old('jenjang', 'S1') === $j)>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection
