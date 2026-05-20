@extends('layouts.operator')

@section('title', 'Tambah Reviewer Baru')

@php $activeNav = 'reviewer.data'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Tambah Reviewer</h4>
            <p class="text-muted small mb-0">Daftarkan dosen baru sebagai reviewer (akun otomatis aktif sebagai reviewer)</p>
        </div>
        <a href="{{ route('operator.reviewer.data') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    <form method="POST" action="{{ route('operator.reviewer.store-new') }}">
        @csrf

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-key-2-line text-primary me-2"></i>Akun Login</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" required class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                        @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Dipakai untuk login.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" required class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" required minlength="6" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" required minlength="6" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-user-line text-primary me-2"></i>Identitas Reviewer</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nama Lengkap (dengan gelar) <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" required class="form-control" value="{{ old('nama_lengkap') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIDN</label>
                        <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}">
                        @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                        <select name="fakultas_id" required class="form-select">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach ($fakultasList as $f)
                                <option value="{{ $f->id }}" @selected(old('fakultas_id') == $f->id)>{{ $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select name="prodi_id" required class="form-select">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodiList as $p)
                                <option value="{{ $p->id }}" data-fakultas="{{ $p->fakultas_id }}" @selected(old('prodi_id') == $p->id)>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jabatan Fungsional</label>
                        <select name="jabatan_fungsional" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach (['Tenaga Pengajar','Asisten Ahli','Lektor','Lektor Kepala','Profesor'] as $j)
                                <option value="{{ $j }}" @selected(old('jabatan_fungsional') === $j)>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach (['S1','S2','S3'] as $p)
                                <option value="{{ $p }}" @selected(old('pendidikan_terakhir') === $p)>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bidang Keahlian</label>
                        <div class="row g-2">
                            @foreach ($keahlianList as $k)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian_ids[]" id="k{{ $k->id }}" value="{{ $k->id }}" @checked(in_array($k->id, old('keahlian_ids', [])))>
                                        <label class="form-check-label" for="k{{ $k->id }}">{{ $k->nama }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('operator.reviewer.data') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="ri-user-add-line me-1"></i> Simpan Reviewer</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fakSelect = document.querySelector('select[name="fakultas_id"]');
    const prodiSelect = document.querySelector('select[name="prodi_id"]');
    if (!fakSelect || !prodiSelect) return;
    const allOptions = Array.from(prodiSelect.querySelectorAll('option[data-fakultas]'));
    function applyFilter() {
        const fakId = fakSelect.value;
        prodiSelect.value = '';
        allOptions.forEach(opt => { opt.hidden = fakId && opt.dataset.fakultas !== fakId; });
    }
    fakSelect.addEventListener('change', applyFilter);
    if (fakSelect.value) applyFilter();
});
</script>
@endsection
