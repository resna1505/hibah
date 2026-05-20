@extends('layouts.dosen')

@section('title', 'Edit Profil Dosen')

@php $activeNav = 'profil'; @endphp

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">Edit Profil</h4>
                <p class="text-muted mb-0 small">Perbarui biodata dosen dan password akun</p>
            </div>
            <a href="{{ route('dosen.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            {{-- BIODATA --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Biodata</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('dosen.profil.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">NIK <span class="text-muted small">(tidak dapat diubah)</span></label>
                                    <input type="text" class="form-control" value="{{ $user->nik }}" disabled>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" required class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        value="{{ old('nama_lengkap', $dosen?->nama_lengkap) }}">
                                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <select name="pendidikan_terakhir" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        @foreach (['S1', 'S2', 'S3'] as $p)
                                            <option value="{{ $p }}" @selected(old('pendidikan_terakhir', $dosen?->pendidikan_terakhir) === $p)>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIDN</label>
                                    <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                                        value="{{ old('nidn', $dosen?->nidn) }}">
                                    @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIDK</label>
                                    <input type="text" name="nidk" class="form-control @error('nidk') is-invalid @enderror"
                                        value="{{ old('nidk', $dosen?->nidk) }}">
                                    @error('nidk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fakultas <span class="text-danger">*</span></label>
                                    <select name="fakultas_id" required class="form-select @error('fakultas_id') is-invalid @enderror">
                                        @foreach ($fakultasList as $f)
                                            <option value="{{ $f->id }}" @selected(old('fakultas_id', $dosen?->fakultas_id) == $f->id)>{{ $f->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi_id" required class="form-select @error('prodi_id') is-invalid @enderror">
                                        @foreach ($prodiList as $p)
                                            <option value="{{ $p->id }}" @selected(old('prodi_id', $dosen?->prodi_id) == $p->id)>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jabatan Fungsional</label>
                                    <select name="jabatan_fungsional" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        @foreach (['Tenaga Pengajar','Asisten Ahli','Lektor','Lektor Kepala','Profesor'] as $j)
                                            <option value="{{ $j }}" @selected(old('jabatan_fungsional', $dosen?->jabatan_fungsional) === $j)>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pangkat / Golongan</label>
                                    <input type="text" name="pangkat_golongan" class="form-control"
                                        value="{{ old('pangkat_golongan', $dosen?->pangkat_golongan) }}" placeholder="Misal: III/c">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $dosen?->no_hp) }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Scopus ID</label>
                                    <input type="text" name="scopus_id" class="form-control" value="{{ old('scopus_id', $dosen?->scopus_id) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Google Scholar ID</label>
                                    <input type="text" name="google_scholar_id" class="form-control" value="{{ old('google_scholar_id', $dosen?->google_scholar_id) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">SINTA ID</label>
                                    <input type="text" name="sinta_id" class="form-control" value="{{ old('sinta_id', $dosen?->sinta_id) }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Sinta Score</label>
                                    <input type="number" min="0" name="sinta_score" class="form-control" value="{{ old('sinta_score', $dosen?->sinta_score ?? 0) }}">
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label">Foto Profil <span class="text-muted small">(JPG/PNG, max 2MB)</span></label>
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    @if ($dosen?->foto_path)
                                        <small class="text-muted">Foto saat ini: <a href="{{ asset('storage/' . $dosen->foto_path) }}" target="_blank">lihat</a></small>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Bidang Keahlian</label>
                                    <div class="row g-2">
                                        @foreach ($keahlianList as $k)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="keahlian_ids[]" id="k{{ $k->id }}"
                                                        value="{{ $k->id }}" @checked(in_array($k->id, old('keahlian_ids', $keahlianIds)))>
                                                    <label class="form-check-label" for="k{{ $k->id }}">{{ $k->nama }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- UBAH PASSWORD --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Ubah Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('dosen.profil.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" required class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password" required minlength="6" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Minimal 6 karakter.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" required class="form-control">
                            </div>

                            <button type="submit" class="btn btn-warning w-100">
                                <i class="ri-lock-password-line me-1"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
