@extends('layouts.operator')

@section('title', 'Master Fakultas & Program Studi')

@php $activeNav = 'master.fakultas'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Fakultas & Program Studi</h4>
            <p class="text-muted small mb-0">Kelola fakultas beserta program studi di bawahnya. Dipakai di profil dosen & proposal.</p>
        </div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mTambahFakultas">
            <i class="ri-add-line"></i> Tambah Fakultas
        </button>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger small">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    @forelse ($fakultasList as $f)
        @php
            $fakDipakai = ($fakultasUsage[$f->id] ?? 0) > 0 || $f->prodi->count() > 0;
        @endphp
        <div class="card border-0 shadow-sm mb-3">
            {{-- Header Fakultas --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="badge bg-primary-subtle text-primary me-1"><code class="text-primary">{{ $f->kode }}</code></span>
                    <strong>{{ $f->nama }}</strong>
                    @if (! $f->is_active)<span class="badge bg-secondary-subtle text-secondary ms-1">Nonaktif</span>@endif
                    <span class="text-muted small ms-1">· {{ $f->prodi->count() }} prodi</span>
                    @if (($fakultasUsage[$f->id] ?? 0) > 0)
                        <span class="badge bg-info-subtle text-info ms-1">{{ $fakultasUsage[$f->id] }} dosen</span>
                    @endif
                </div>
                <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mTambahProdi{{ $f->id }}">
                        <i class="ri-add-line"></i> Tambah Prodi
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEditFakultas{{ $f->id }}" title="Edit fakultas">
                        <i class="ri-edit-line"></i>
                    </button>
                    <form method="POST" action="{{ route('operator.master.fakultas.destroy', $f) }}" class="d-inline" onsubmit="return confirm('Hapus fakultas {{ $f->nama }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Hapus fakultas" {{ $fakDipakai ? 'disabled' : '' }}>
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Children: Program Studi --}}
            <div class="card-body p-0">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="120" class="ps-3">Kode</th>
                            <th>Nama Program Studi</th>
                            <th width="90">Jenjang</th>
                            <th width="100">Status</th>
                            <th width="110">Dipakai</th>
                            <th width="110"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($f->prodi as $p)
                            <tr>
                                <td class="ps-3"><code>{{ $p->kode }}</code></td>
                                <td>{{ $p->nama }}</td>
                                <td><span class="badge bg-light text-dark">{{ $p->jenjang }}</span></td>
                                <td>
                                    @if ($p->is_active)
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="small">
                                    @if (($prodiUsage[$p->id] ?? 0) > 0)
                                        <span class="badge bg-info-subtle text-info">{{ $prodiUsage[$p->id] }} dosen</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEditProdi{{ $p->id }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form method="POST" action="{{ route('operator.master.prodi.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus program studi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus" {{ ($prodiUsage[$p->id] ?? 0) > 0 ? 'disabled' : '' }}>
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit Prodi --}}
                            <div class="modal fade" id="mEditProdi{{ $p->id }}" tabindex="-1">
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
                                                        @foreach ($fakultasList as $fx)
                                                            <option value="{{ $fx->id }}" @selected($p->fakultas_id == $fx->id)>{{ $fx->kode }} — {{ $fx->nama }}</option>
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
                                                        <input type="checkbox" name="is_active" value="1" id="prodiAktif{{ $p->id }}" class="form-check-input" @checked($p->is_active)>
                                                        <label for="prodiAktif{{ $p->id }}" class="form-check-label small">Aktif <span class="text-muted">(tidak aktif = tidak muncul di pilihan prodi)</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-3">Belum ada program studi. Tambah lewat tombol <em>Tambah Prodi</em>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Edit Fakultas --}}
        <div class="modal fade" id="mEditFakultas{{ $f->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('operator.master.fakultas.update', $f) }}" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h6 class="modal-title">Edit Fakultas</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label">Kode</label>
                                <input type="text" name="kode" class="form-control" value="{{ $f->kode }}" required maxlength="20">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Fakultas</label>
                                <input type="text" name="nama" class="form-control" value="{{ $f->nama }}" required maxlength="150">
                            </div>
                            <div class="col-12">
                                <input type="hidden" name="is_active" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" id="fakAktif{{ $f->id }}" class="form-check-input" @checked($f->is_active)>
                                    <label for="fakAktif{{ $f->id }}" class="form-check-label small">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>

        {{-- Modal Tambah Prodi (untuk fakultas ini) --}}
        <div class="modal fade" id="mTambahProdi{{ $f->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('operator.master.prodi.store') }}" class="modal-content">
                    @csrf
                    <input type="hidden" name="fakultas_id" value="{{ $f->id }}">
                    <div class="modal-header"><h6 class="modal-title">Tambah Prodi — {{ $f->nama }}</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label">Kode <span class="text-danger">*</span></label>
                                <input type="text" name="kode" class="form-control" required maxlength="20" placeholder="Contoh: SI">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required maxlength="150" placeholder="Contoh: Sistem Informasi">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenjang <span class="text-danger">*</span></label>
                                <select name="jenjang" class="form-select" required>
                                    @foreach ($jenjangOpsi as $j)
                                        <option value="{{ $j }}" @selected($j === 'S1')>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-5">
                Belum ada fakultas. Tambah lewat tombol <em>Tambah Fakultas</em> di atas.
            </div>
        </div>
    @endforelse

    {{-- Modal Tambah Fakultas --}}
    <div class="modal fade" id="mTambahFakultas" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operator.master.fakultas.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Fakultas</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="text" name="kode" class="form-control" required maxlength="20" value="{{ old('kode') }}" placeholder="Contoh: FIK">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Fakultas <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required maxlength="150" value="{{ old('nama') }}" placeholder="Contoh: Fakultas Ilmu Komputer">
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection
