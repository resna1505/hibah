@extends('layouts.master-without-nav')

@section('title', 'Riwayat HKI')

@php $activeNav = 'riwayat'; @endphp

@section('content')
<div class="min-vh-100 bg-light">
    @include('dosen._partials.topbar')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Riwayat HKI</h4>
                <p class="text-muted small mb-0">Daftar Hak Kekayaan Intelektual yang Anda miliki</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#formAdd">
                <i class="ri-add-line"></i> Tambah HKI
            </button>
        </div>

        <div class="collapse mb-4 {{ $errors->any() ? 'show' : '' }}" id="formAdd">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Form Tambah HKI</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dosen.riwayat.hki.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Jenis HKI <span class="text-danger">*</span></label>
                                <select name="jenis_hki" required class="form-select">
                                    @foreach (['Hak Cipta','Paten','Merek','Desain Industri','Rahasia Dagang','Lainnya'] as $j)
                                        <option value="{{ $j }}">{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">Judul HKI <span class="text-danger">*</span></label>
                                <input type="text" name="judul" required class="form-control" value="{{ old('judul') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">No Pendaftaran</label>
                                <input type="text" name="no_pendaftaran" class="form-control" value="{{ old('no_pendaftaran') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">No Sertifikat</label>
                                <input type="text" name="no_sertifikat" class="form-control" value="{{ old('no_sertifikat') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tahun Pengajuan</label>
                                <input type="number" name="tahun_pengajuan" min="1990" max="{{ now()->year + 1 }}"
                                    class="form-control" value="{{ old('tahun_pengajuan') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" min="1990" max="{{ now()->year + 1 }}"
                                    class="form-control" value="{{ old('tahun_terbit') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Peran <span class="text-danger">*</span></label>
                                <select name="peran" required class="form-select">
                                    <option value="ketua">Ketua</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status HKI <span class="text-danger">*</span></label>
                                <select name="status_hki" required class="form-select">
                                    <option value="Proses">Proses</option>
                                    <option value="Terdaftar">Terdaftar</option>
                                    <option value="Granted">Granted</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">Upload Dokumen HKI <span class="text-muted small">(PDF/JPG/PNG, max 5MB)</span></label>
                                <input type="file" name="file" class="form-control" accept=".pdf,image/jpeg,image/png">
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
                                <th>Jenis</th>
                                <th>Judul</th>
                                <th>No Pendaftaran</th>
                                <th>No Sertifikat</th>
                                <th>Tahun</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($list as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="small">{{ $r->jenis_hki }}</td>
                                    <td class="small">{{ $r->judul }}</td>
                                    <td class="small">{{ $r->no_pendaftaran ?? '-' }}</td>
                                    <td class="small">{{ $r->no_sertifikat ?? '-' }}</td>
                                    <td class="small">
                                        {{ $r->tahun_pengajuan ?? '-' }}
                                        @if ($r->tahun_terbit) &rarr; {{ $r->tahun_terbit }} @endif
                                    </td>
                                    <td class="small">{{ ucfirst($r->peran) }}</td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">{{ $r->status_hki }}</span>
                                    </td>
                                    <td>
                                        @if ($r->file_path)
                                            <a href="{{ asset('storage/' . $r->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i></a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('dosen.riwayat.hki.destroy', $r) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus HKI ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-4">Belum ada riwayat HKI.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
