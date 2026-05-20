@extends('layouts.master-without-nav')

@section('title', 'Riwayat PKM')

@php $activeNav = 'riwayat'; @endphp

@section('content')
<div class="min-vh-100 bg-light">
    @include('dosen._partials.topbar')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Riwayat Hibah PKM</h4>
                <p class="text-muted small mb-0">Daftar riwayat Pengabdian Kepada Masyarakat yang pernah Anda kerjakan</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#formAdd">
                <i class="ri-add-line"></i> Tambah Riwayat
            </button>
        </div>

        <div class="collapse mb-4 {{ $errors->any() ? 'show' : '' }}" id="formAdd">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Form Tambah Riwayat PKM</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dosen.riwayat.pkm.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" required min="1990" max="{{ now()->year + 1 }}"
                                    class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', now()->year) }}">
                            </div>
                            <div class="col-md-10">
                                <label class="form-label">Judul PKM <span class="text-danger">*</span></label>
                                <input type="text" name="judul" required class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Skema PKM</label>
                                <input type="text" name="skema_pkm" class="form-control" value="{{ old('skema_pkm') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sumber Dana</label>
                                <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Peran <span class="text-danger">*</span></label>
                                <select name="peran" required class="form-select">
                                    <option value="ketua">Ketua</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" required class="form-select">
                                    <option value="selesai">Selesai</option>
                                    <option value="berjalan">Berjalan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lokasi PKM</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mitra PKM</label>
                                <input type="text" name="mitra" class="form-control" value="{{ old('mitra') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Luaran PKM</label>
                                <input type="text" name="luaran" class="form-control" value="{{ old('luaran') }}">
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#formAdd">Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tahun</th>
                                <th>Judul</th>
                                <th>Skema</th>
                                <th>Lokasi</th>
                                <th>Mitra</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($list as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $r->tahun }}</td>
                                    <td class="small">{{ $r->judul }}</td>
                                    <td class="small">{{ $r->skema_pkm ?? '-' }}</td>
                                    <td class="small">{{ $r->lokasi ?? '-' }}</td>
                                    <td class="small">{{ $r->mitra ?? '-' }}</td>
                                    <td class="small">{{ ucfirst($r->peran) }}</td>
                                    <td>
                                        <span class="badge {{ $r->status === 'selesai' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                            {{ ucfirst($r->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('dosen.riwayat.pkm.destroy', $r) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus riwayat ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada riwayat PKM.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
