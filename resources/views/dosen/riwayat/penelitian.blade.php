@extends('layouts.dosen')

@section('title', 'Riwayat Penelitian')

@php $activeNav = 'riwayat'; @endphp

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Riwayat Hibah Penelitian</h4>
                <p class="text-muted small mb-0">Daftar riwayat penelitian yang pernah Anda kerjakan</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#formAdd">
                <i class="ri-add-line"></i> Tambah Riwayat
            </button>
        </div>

        {{-- Form Add (collapsible) --}}
        <div class="collapse mb-4 {{ $errors->any() ? 'show' : '' }}" id="formAdd">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Form Tambah Riwayat Penelitian</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dosen.riwayat.penelitian.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="tahun" required min="1990" max="{{ now()->year + 1 }}"
                                    class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', now()->year) }}">
                            </div>
                            <div class="col-md-10">
                                <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
                                <input type="text" name="judul" required class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sumber Pendanaan</label>
                                <input type="text" name="sumber_pendanaan" class="form-control" value="{{ old('sumber_pendanaan') }}" placeholder="Misal: DIKTI, Internal UNIBA">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Skema Penelitian</label>
                                <input type="text" name="skema_penelitian" class="form-control" value="{{ old('skema_penelitian') }}" placeholder="Misal: PDP, PTUPT">
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
                            <div class="col-md-12">
                                <label class="form-label">Luaran Penelitian</label>
                                <input type="text" name="luaran" class="form-control" value="{{ old('luaran') }}" placeholder="Misal: Artikel Jurnal Sinta 3">
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

        {{-- List --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tahun</th>
                                <th>Judul</th>
                                <th>Sumber Dana</th>
                                <th>Skema</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Luaran</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($list as $i => $r)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $r->tahun }}</td>
                                    <td class="small">{{ $r->judul }}</td>
                                    <td class="small">{{ $r->sumber_pendanaan ?? '-' }}</td>
                                    <td class="small">{{ $r->skema_penelitian ?? '-' }}</td>
                                    <td class="small">{{ ucfirst($r->peran) }}</td>
                                    <td>
                                        <span class="badge {{ $r->status === 'selesai' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                            {{ ucfirst($r->status) }}
                                        </span>
                                    </td>
                                    <td class="small">{{ $r->luaran ?? '-' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('dosen.riwayat.penelitian.destroy', $r) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus riwayat ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-4">Belum ada riwayat penelitian. Klik "Tambah Riwayat" untuk menambah.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
