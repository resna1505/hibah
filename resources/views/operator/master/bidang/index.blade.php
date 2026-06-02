@extends('layouts.operator')

@section('title', 'Master Bidang Strategis')

@php $activeNav = 'master.bidang'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Master Bidang Strategis</h4>
            <p class="text-muted small mb-0">Kelola daftar bidang strategis yang muncul di form proposal Penelitian/PKM.</p>
        </div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mTambah">
            <i class="ri-add-line"></i> Tambah Bidang
        </button>
    </div>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger small">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="80">Kode</th>
                        <th width="280">Nama Bidang</th>
                        <th>Deskripsi</th>
                        <th width="100">Status</th>
                        <th width="110">Dipakai</th>
                        <th width="140"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $b)
                        <tr>
                            <td><code>{{ $b->kode }}</code></td>
                            <td><strong>{{ $b->nama }}</strong></td>
                            <td class="small text-muted">{{ $b->deskripsi ?? '-' }}</td>
                            <td>
                                @if ($b->is_active)
                                    <span class="badge bg-success-subtle text-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="small">
                                @if (($usage[$b->id] ?? 0) > 0)
                                    <span class="badge bg-info-subtle text-info">{{ $usage[$b->id] }} proposal</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEdit{{ $b->id }}" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <form method="POST" action="{{ route('operator.master.bidang.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Hapus bidang strategis ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus" {{ ($usage[$b->id] ?? 0) > 0 ? 'disabled' : '' }}>
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Edit per row --}}
                        <div class="modal fade" id="mEdit{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('operator.master.bidang.update', $b) }}" class="modal-content">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title">Edit Bidang Strategis</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label class="form-label">Kode</label>
                                                <input type="number" name="kode" class="form-control" value="{{ $b->kode }}" required min="1" max="99">
                                            </div>
                                            <div class="col-md-9">
                                                <label class="form-label">Nama Bidang</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $b->nama }}" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" rows="2" class="form-control">{{ $b->deskripsi }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <input type="hidden" name="is_active" value="0">
                                                <div class="form-check">
                                                    <input type="checkbox" name="is_active" value="1" id="aktif{{ $b->id }}" class="form-check-input" @checked($b->is_active)>
                                                    <label for="aktif{{ $b->id }}" class="form-check-label small">Aktif <span class="text-muted">(tidak aktif = tidak muncul di form dosen)</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada bidang strategis. Tambah lewat tombol di atas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="mTambah" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operator.master.bidang.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Bidang Strategis</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="number" name="kode" class="form-control" required min="1" max="99" value="{{ old('kode') }}">
                            <small class="text-muted">Nomor urut bidang</small>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Nama Bidang <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}" placeholder="Contoh: Pangan">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" rows="2" class="form-control" placeholder="Penjelasan singkat lingkup bidang (opsional)">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection
