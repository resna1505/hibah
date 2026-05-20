@extends('layouts.master-without-nav')

@section('title', 'Pendaftaran Dosen - Hibah Internal UNIBA')

@section('content')
<div class="min-vh-100 bg-light py-4">
    <div class="container">
        <div class="text-center mb-4">
            <h4 class="text-primary mb-1">Pendaftaran Dosen</h4>
            <p class="text-muted small">Hibah Internal LPPM Universitas Batam</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali isian:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Akun Login --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-key-2-line me-2 text-primary"></i>1. Akun Login</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" required class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}" placeholder="Nomor Induk Karyawan UNIBA">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Dipakai untuk login.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email Aktif <span class="text-danger">*</span></label>
                            <input type="email" name="email" required class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required minlength="6"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Minimal 6 karakter.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" required minlength="6" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Identitas Dosen --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-user-line me-2 text-primary"></i>2. Identitas Dosen</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Lengkap (dengan gelar) <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" required class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap') }}" placeholder="Contoh: Dr. Andi Saputra, S.T., M.Kom">
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Foto Profil <span class="text-muted small">(opsional, max 2MB)</span></label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg,image/png">
                            @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIDN <span class="text-muted small">(salah satu wajib)</span></label>
                            <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                                value="{{ old('nidn') }}" placeholder="Nomor Induk Dosen Nasional">
                            @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIDK <span class="text-muted small">(salah satu wajib)</span></label>
                            <input type="text" name="nidk" class="form-control @error('nidk') is-invalid @enderror"
                                value="{{ old('nidk') }}" placeholder="Nomor Induk Dosen Khusus">
                            @error('nidk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Akademik --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-building-line me-2 text-primary"></i>3. Akademik</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas_id" required class="form-select @error('fakultas_id') is-invalid @enderror">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultasList as $f)
                                    <option value="{{ $f->id }}" @selected(old('fakultas_id') == $f->id)>{{ $f->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi_id" required class="form-select @error('prodi_id') is-invalid @enderror">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach ($prodiList as $p)
                                    <option value="{{ $p->id }}" data-fakultas="{{ $p->fakultas_id }}" @selected(old('prodi_id') == $p->id)>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jabatan Fungsional</label>
                            <select name="jabatan_fungsional" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach (['Tenaga Pengajar','Asisten Ahli','Lektor','Lektor Kepala','Profesor'] as $j)
                                    <option value="{{ $j }}" @selected(old('jabatan_fungsional') === $j)>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pangkat / Golongan</label>
                            <input type="text" name="pangkat_golongan" class="form-control"
                                value="{{ old('pangkat_golongan') }}" placeholder="Misal: III/c">
                        </div>
                        <div class="col-md-4">
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
                                            <input class="form-check-input" type="checkbox" name="keahlian_ids[]" id="rk{{ $k->id }}"
                                                value="{{ $k->id }}" @checked(in_array($k->id, old('keahlian_ids', [])))>
                                            <label class="form-check-label" for="rk{{ $k->id }}">{{ $k->nama }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 4: Profil Akademik Online --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-global-line me-2 text-primary"></i>4. Profil Akademik Online <span class="text-muted small">(opsional)</span></h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Scopus ID</label>
                            <input type="text" name="scopus_id" class="form-control" value="{{ old('scopus_id') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Google Scholar ID / Link</label>
                            <input type="text" name="google_scholar_id" class="form-control" value="{{ old('google_scholar_id') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">SINTA ID / Link</label>
                            <input type="text" name="sinta_id" class="form-control" value="{{ old('sinta_id') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sinta Score</label>
                            <input type="number" min="0" name="sinta_score" class="form-control" value="{{ old('sinta_score', 0) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 5: Persetujuan --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input @error('agreement') is-invalid @enderror" type="checkbox" name="agreement" id="agreement" value="1" @checked(old('agreement'))>
                        <label class="form-check-label" for="agreement">
                            Saya menyatakan bahwa data yang diisi pada formulir ini benar dan dapat dipertanggungjawabkan. Riwayat hibah penelitian, PKM, dan HKI dapat dilengkapi setelah akun aktif melalui menu Profil.
                        </label>
                        @error('agreement')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('login') }}" class="text-muted text-decoration-none"><i class="ri-arrow-left-line"></i> Kembali ke Login</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="ri-user-add-line me-1"></i> Daftarkan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Filter prodi berdasarkan fakultas terpilih
document.addEventListener('DOMContentLoaded', function () {
    const fakSelect = document.querySelector('select[name="fakultas_id"]');
    const prodiSelect = document.querySelector('select[name="prodi_id"]');
    if (!fakSelect || !prodiSelect) return;

    const allOptions = Array.from(prodiSelect.querySelectorAll('option[data-fakultas]'));

    function applyFilter() {
        const fakId = fakSelect.value;
        prodiSelect.value = '';
        allOptions.forEach(opt => {
            opt.hidden = fakId && opt.dataset.fakultas !== fakId;
        });
    }

    fakSelect.addEventListener('change', applyFilter);
    if (fakSelect.value) applyFilter();
});
</script>
@endsection
