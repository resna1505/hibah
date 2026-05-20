@extends('layouts.operator')

@section('title', 'Master RAB')

@php $activeNav = 'master.rab'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Master RAB</h4>
            <p class="text-muted small mb-0">Kelola Kelompok &amp; Komponen RAB (digunakan saat dosen menyusun anggaran proposal).</p>
        </div>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mKelompok">
            <i class="ri-add-line"></i> Tambah Kelompok
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger small">
            @foreach ($errors->all() as $err)<div>{{ $err }}</div>@endforeach
        </div>
    @endif

    @forelse ($kelompok as $kel)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex align-items-center">
                <div class="flex-grow-1">
                    <strong>{{ $kel->urutan }}. {{ $kel->nama }}</strong>
                    <span class="text-muted small">&middot; kode: <code>{{ $kel->kode }}</code></span>
                    @if (! $kel->is_active)
                        <span class="badge bg-secondary ms-1">nonaktif</span>
                    @endif
                </div>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEditKel{{ $kel->id }}">
                        <i class="ri-edit-line"></i> Edit
                    </button>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#mKomp{{ $kel->id }}">
                        <i class="ri-add-line"></i> Komponen
                    </button>
                    <form method="POST" action="{{ route('operator.master.rab.kelompok.destroy', $kel) }}" class="d-inline" onsubmit="return confirm('Hapus kelompok ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Urutan</th>
                            <th width="180">Kode</th>
                            <th>Nama Komponen</th>
                            <th width="120">Status</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kel->komponen as $kp)
                            <tr>
                                <td>{{ $kp->urutan }}</td>
                                <td><code>{{ $kp->kode }}</code></td>
                                <td>{{ $kp->nama }}</td>
                                <td>
                                    @if ($kp->is_active)
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mEditKomp{{ $kp->id }}">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form method="POST" action="{{ route('operator.master.rab.komponen.destroy', $kp) }}" class="d-inline" onsubmit="return confirm('Hapus komponen ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada komponen. Tambah via tombol "Komponen" di atas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal: Edit Kelompok --}}
        <div class="modal fade" id="mEditKel{{ $kel->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('operator.master.rab.kelompok.update', $kel) }}" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h6 class="modal-title">Edit Kelompok</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-2"><label class="form-label">Kode</label><input type="text" name="kode" class="form-control" value="{{ $kel->kode }}" required></div>
                        <div class="mb-2"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="{{ $kel->nama }}" required></div>
                        <div class="mb-2"><label class="form-label">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ $kel->urutan }}"></div>
                        <div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked($kel->is_active) id="kelAktif{{ $kel->id }}"><label class="form-check-label" for="kelAktif{{ $kel->id }}">Aktif</label></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>

        {{-- Modal: Tambah Komponen --}}
        <div class="modal fade" id="mKomp{{ $kel->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('operator.master.rab.komponen.store', $kel) }}" class="modal-content">
                    @csrf
                    <div class="modal-header"><h6 class="modal-title">Tambah Komponen ke "{{ $kel->nama }}"</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-2"><label class="form-label">Kode <span class="text-muted small">(opsional, auto)</span></label><input type="text" name="kode" class="form-control"></div>
                        <div class="mb-2"><label class="form-label">Nama <span class="text-danger">*</span></label><input type="text" name="nama" class="form-control" required></div>
                        <div class="mb-2"><label class="form-label">Urutan</label><input type="number" name="urutan" class="form-control"></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                </form>
            </div>
        </div>

        {{-- Modals: Edit Komponen per row --}}
        @foreach ($kel->komponen as $kp)
            <div class="modal fade" id="mEditKomp{{ $kp->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('operator.master.rab.komponen.update', $kp) }}" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header"><h6 class="modal-title">Edit Komponen</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-2"><label class="form-label">Kode</label><input type="text" name="kode" class="form-control" value="{{ $kp->kode }}" required></div>
                            <div class="mb-2"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="{{ $kp->nama }}" required></div>
                            <div class="mb-2"><label class="form-label">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ $kp->urutan }}"></div>
                            <div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked($kp->is_active) id="kpAktif{{ $kp->id }}"><label class="form-check-label" for="kpAktif{{ $kp->id }}">Aktif</label></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
                    </form>
                </div>
            </div>
        @endforeach
    @empty
        <div class="alert alert-info">Belum ada kelompok RAB.</div>
    @endforelse

    {{-- Modal: Tambah Kelompok --}}
    <div class="modal fade" id="mKelompok" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('operator.master.rab.kelompok.store') }}" class="modal-content">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Kelompok RAB</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Kode <span class="text-danger">*</span></label><input type="text" name="kode" class="form-control" required placeholder="mis: honor"></div>
                    <div class="mb-2"><label class="form-label">Nama <span class="text-danger">*</span></label><input type="text" name="nama" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Urutan</label><input type="number" name="urutan" class="form-control"></div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection
