@extends('layouts.dosen')

@section('title', $proposal ? 'Edit Usulan Penelitian' : 'Ajukan Usulan Penelitian')

@php
    $activeNav = 'penelitian';
    $isEdit = (bool) $proposal;
    $action = $isEdit ? route('dosen.penelitian.update', $proposal) : route('dosen.penelitian.store');
    $jadwalJson    = $proposal?->jadwal_json ?? [];
    $jadwalRows    = $jadwalJson['rows'] ?? [];
    $jadwalBulan   = $jadwalJson['bulan_mulai'] ?? '';
    $jadwalLegacy  = $jadwalJson['text'] ?? '';
    $durasiAwal    = $proposal?->durasi_bulan ?? 12;
    $hasilJson = $proposal?->hasil_diharapkan_json ?? [
        ['jenis' => 'Publikasi ilmiah di Jurnal Scopus/Sinta (1-4)', 'target' => 'Published/LOA'],
        ['jenis' => 'Pemakalah dalam temu ilmiah internasional atau nasional', 'target' => 'Conference'],
        ['jenis' => 'Hak Kekayaan Intelektual', 'target' => 'Terdaftar HKI'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $isEdit ? 'Edit' : 'Ajukan' }} Usulan Penelitian</h4>
            <p class="text-muted small mb-0">{{ $skema->nama }} &middot; {{ $periode->nama }} &middot; Maks Rp {{ number_format($skema->max_anggaran, 0, ',', '.') }}</p>
        </div>
        <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="formProposal">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        {{-- Section 1: Identitas Pengusul --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-team-line text-primary me-2"></i>1. Identitas Pengusul</h6></div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Ketua Pengusul</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->dosen->nama_lengkap }}" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIDN</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->dosen->nidn ?? '-' }}" disabled>
                    </div>
                </div>

                <h6 class="mt-3">Anggota Dosen</h6>
                <div id="anggotaDosen">
                    @forelse ($anggotaDosen as $i => $a)
                        <div class="row g-2 mb-2 anggota-row">
                            <div class="col-md-6">
                                <select name="anggota_dosen_id[]" class="form-select">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosenList as $d)
                                        <option value="{{ $d->id }}" @selected($a->dosen_id == $d->id)>{{ $d->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="anggota_bidang_tugas[]" class="form-control" placeholder="Bidang tugas" value="{{ $a->bidang_tugas }}">
                            </div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.anggota-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                    @empty @endforelse
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAnggotaDosen()"><i class="ri-add-line"></i> Tambah Anggota Dosen</button>

                <h6 class="mt-4">Anggota Mahasiswa</h6>
                <div id="anggotaMahasiswa">
                    @foreach ($mahasiswa as $m)
                        <div class="row g-2 mb-2 mahasiswa-row">
                            <div class="col-md-3"><input type="text" name="mahasiswa_nama[]" class="form-control" placeholder="Nama" value="{{ $m->nama_mahasiswa }}"></div>
                            <div class="col-md-2"><input type="text" name="mahasiswa_nim[]" class="form-control" placeholder="NIM" value="{{ $m->nim }}"></div>
                            <div class="col-md-3"><input type="text" name="mahasiswa_prodi[]" class="form-control" placeholder="Program Studi" value="{{ $m->program_studi }}"></div>
                            <div class="col-md-3"><input type="text" name="mahasiswa_bidang_tugas[]" class="form-control" placeholder="Bidang tugas" value="{{ $m->bidang_tugas }}"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mahasiswa-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMahasiswa()"><i class="ri-add-line"></i> Tambah Mahasiswa</button>
            </div>
        </div>

        {{-- Section 2: Identitas Proposal --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-file-text-line text-primary me-2"></i>2. Identitas Proposal</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-10">
                        <label class="form-label">Judul Proposal <span class="text-danger">*</span> <span class="text-muted small">(maks 20 kata)</span></label>
                        <input type="text" name="judul" required class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $proposal?->judul) }}">
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Durasi (bln) <span class="text-danger">*</span></label>
                        <input type="number" name="durasi_bulan" required min="1" max="{{ $skema->max_durasi_bulan }}" class="form-control"
                            value="{{ old('durasi_bulan', $proposal?->durasi_bulan ?? 12) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Ringkasan <span class="text-muted small">(maks 300 kata, berisi urgensi/tujuan/metode/luaran)</span></label>
                        <textarea name="ringkasan" rows="4" class="form-control word-counter" data-max="300">{{ old('ringkasan', $proposal?->ringkasan) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Kata Kunci <span class="text-muted small">(5 kata dipisahkan ; — contoh: harga; pemasaran; UMKM; digital; Batam)</span></label>
                        <input type="text" name="kata_kunci" class="form-control" value="{{ old('kata_kunci', $proposal?->kata_kunci) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2b: Bidang Strategis --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-compass-3-line text-primary me-2"></i>2b. Bidang Strategis</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Pilih Bidang Strategis <span class="text-muted small">(sesuai prioritas riset nasional)</span></label>
                        <select name="bidang_strategis_id" class="form-select">
                            <option value="">-- Pilih Bidang --</option>
                            @foreach ($bidangList as $b)
                                <option value="{{ $b->id }}" @selected(old('bidang_strategis_id', $proposal?->bidang_strategis_id) == $b->id)>
                                    {{ $b->kode }}. {{ $b->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Rumusan Masalah Bidang</label>
                        <textarea name="rumusan_masalah_bidang" rows="3" class="form-control">{{ old('rumusan_masalah_bidang', $proposal?->rumusan_masalah_bidang) }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Uraian Bidang <span class="text-muted small">(relevansi penelitian dengan bidang strategis)</span></label>
                        <textarea name="uraian_bidang" rows="3" class="form-control">{{ old('uraian_bidang', $proposal?->uraian_bidang) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2c: Mitra Penelitian (opsional) --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="mb-0"><i class="ri-shake-hands-line text-primary me-2"></i>2c. Mitra Penelitian</h6>
                    <span class="badge bg-secondary-subtle text-secondary border">Opsional</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMitra()"><i class="ri-add-line"></i> Tambah Mitra</button>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    <i class="ri-information-line"></i>
                    Boleh dikosongkan kalau penelitian dilakukan individual/tim internal.
                    Isi bila ada <strong>kolaborator industri, instansi pemerintah, atau lembaga riset</strong> yang terlibat.
                </p>
                <div id="mitraList">
                    @foreach ($mitraList as $m)
                        <div class="row g-2 mb-2 mitra-row align-items-start">
                            <div class="col-md-3"><input type="text" name="mitra_nama[]" class="form-control" placeholder="Nama mitra" value="{{ $m->nama_mitra }}"></div>
                            <div class="col-md-3"><input type="text" name="mitra_pimpinan[]" class="form-control" placeholder="Pimpinan" value="{{ $m->pimpinan_mitra }}"></div>
                            <div class="col-md-3"><textarea name="mitra_alamat[]" class="form-control" rows="1" placeholder="Alamat">{{ $m->alamat_mitra }}</textarea></div>
                            <div class="col-md-2"><textarea name="mitra_permasalahan[]" class="form-control" rows="1" placeholder="Permasalahan / kontribusi">{{ $m->permasalahan_mitra }}</textarea></div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mitra-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Section 3: Pendahuluan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-book-open-line text-primary me-2"></i>3. Pendahuluan <span class="text-muted small">(maks 1000 kata)</span></h6></div>
            <div class="card-body">
                <p class="text-muted small">Memuat latar belakang, rumusan permasalahan, pendekatan pemecahan masalah, state-of-the-art dan kebaruan, peta jalan (road map) penelitian setidaknya 5 tahun. Sitasi disusun menggunakan Mendeley.</p>
                <textarea name="pendahuluan" rows="10" class="form-control word-counter" data-max="1000">{{ old('pendahuluan', $proposal?->pendahuluan) }}</textarea>
            </div>
        </div>

        {{-- Section 4: Metode --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-flask-line text-primary me-2"></i>4. Metode <span class="text-muted small">(maks 1500 kata)</span></h6></div>
            <div class="card-body">
                <p class="text-muted small">Wajib dilengkapi diagram alir penelitian. Memuat prosedur penelitian, hasil yang diharapkan, indikator capaian, serta anggota tim/mitra yang bertanggung jawab pada setiap tahapan.</p>
                <textarea name="metode" rows="10" class="form-control word-counter" data-max="1500">{{ old('metode', $proposal?->metode) }}</textarea>

                <div class="mt-3">
                    <label class="form-label">Diagram Alir Penelitian <span class="text-muted small">(JPG/PNG, maks 2MB)</span></label>
                    <input type="file" name="metode_diagram" class="form-control" accept="image/jpeg,image/png">
                    @if ($proposal?->metode_diagram_path)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $proposal->metode_diagram_path) }}" target="_blank">lihat</a></small>
                    @endif
                </div>
            </div>
        </div>

        {{-- Section 5: Rencana Luaran --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ri-target-line text-primary me-2"></i>5. Rencana Luaran</h6>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addLuaran()"><i class="ri-add-line"></i> Tambah Baris</button>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-2">Isi target capaian luaran per tahun. Pilih jenis dari daftar; bila tidak terdaftar gunakan kolom isian bebas.</p>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Tahun ke-</th>
                                <th width="120">Kategori</th>
                                <th>Jenis Luaran</th>
                                <th width="180">Status Target Capaian</th>
                                <th>Keterangan</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="luaranBody">
                            @foreach ($rencanaLuaran as $i => $rl)
                                <tr class="luaran-row">
                                    <td><input type="number" min="1" max="5" name="luaran_tahun_ke[]" class="form-control form-control-sm" value="{{ $rl->tahun_ke }}"></td>
                                    <td>
                                        <select name="luaran_kategori[]" class="form-select form-select-sm">
                                            <option value="wajib" @selected($rl->kategori === 'wajib')>Wajib</option>
                                            <option value="tambahan" @selected($rl->kategori === 'tambahan')>Tambahan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="luaran_jenis_id[]" class="form-select form-select-sm mb-1">
                                            <option value="">-- Pilih dari daftar --</option>
                                            @foreach ($jenisLuaranList as $j)
                                                <option value="{{ $j->id }}" @selected($rl->jenis_luaran_id == $j->id)>{{ $j->nama }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="luaran_jenis_text[]" class="form-control form-control-sm" placeholder="atau isi bebas" value="{{ $rl->jenis_luaran_text }}">
                                    </td>
                                    <td><input type="text" name="luaran_status_target[]" class="form-control form-control-sm" placeholder="Submitted/Accepted/Published/Granted" value="{{ $rl->status_target }}"></td>
                                    <td><textarea name="luaran_keterangan[]" rows="1" class="form-control form-control-sm">{{ $rl->keterangan }}</textarea></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.luaran-row').remove()"><i class="ri-delete-bin-line"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Section 6: Jadwal --}}
        @include('dosen._shared.jadwal-table', [
            'sectionNo'    => '6',
            'sectionLabel' => 'Jadwal Penelitian',
            'jadwalRows'   => $jadwalRows,
            'jadwalBulan'  => $jadwalBulan,
            'jadwalLegacy' => $jadwalLegacy,
            'durasiAwal'   => $durasiAwal,
        ])

        {{-- Section 7: Daftar Pustaka --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-book-line text-primary me-2"></i>7. Daftar Pustaka <span class="text-muted small">(maks 500 kata, format Mendeley)</span></h6></div>
            <div class="card-body">
                <textarea name="daftar_pustaka" rows="8" class="form-control word-counter" data-max="500">{{ old('daftar_pustaka', $proposal?->daftar_pustaka) }}</textarea>
            </div>
        </div>

        {{-- Section 8: RAB --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0"><i class="ri-money-dollar-circle-line text-primary me-2"></i>8. Rencana Anggaran Biaya (RAB)</h6>
                <span class="text-muted small">Maks: Rp {{ number_format($skema->max_anggaran, 0, ',', '.') }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="150">Kelompok</th>
                                <th width="180">Komponen</th>
                                <th>Item / Material</th>
                                <th>Justifikasi</th>
                                <th width="75">Qty</th>
                                <th width="75">Satuan</th>
                                <th width="130">Harga Satuan</th>
                                <th width="130">Sub Total</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody id="rabBody">
                            @foreach ($rabItems as $i => $r)
                                <tr class="rab-row">
                                    <td>
                                        <select name="rab_kategori_id[]" class="form-select form-select-sm rab-kategori">
                                            @foreach ($kategoriRab as $k)
                                                <option value="{{ $k->id }}" @selected($r->kategori_rab_id == $k->id)>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="rab_komponen_id[]" class="form-select form-select-sm rab-komponen">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kategoriRab as $k)
                                                @foreach ($k->komponen as $kp)
                                                    <option value="{{ $kp->id }}" data-kategori="{{ $k->id }}" @selected($r->komponen_rab_id == $kp->id)>{{ $kp->nama }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="rab_item[]" class="form-control form-control-sm" value="{{ $r->item }}"></td>
                                    <td><input type="text" name="rab_justifikasi[]" class="form-control form-control-sm" value="{{ $r->justifikasi }}"></td>
                                    <td><input type="number" step="0.01" name="rab_kuantitas[]" class="form-control form-control-sm rab-qty" value="{{ $r->kuantitas }}"></td>
                                    <td><input type="text" name="rab_satuan[]" class="form-control form-control-sm" value="{{ $r->satuan }}"></td>
                                    <td><input type="number" name="rab_harga_satuan[]" class="form-control form-control-sm rab-harga" value="{{ $r->harga_satuan }}"></td>
                                    <td class="rab-subtotal text-end small">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRab(this)"><i class="ri-delete-bin-line"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="7" class="text-end">TOTAL:</td>
                                <td id="rabTotal" class="text-end">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRab()"><i class="ri-add-line"></i> Tambah Baris RAB</button>
            </div>
        </div>

        {{-- Section 9: Pernyataan + Submit --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="checkbox" name="pernyataan_setuju" id="pernyataan" value="1" class="form-check-input"
                        @checked(old('pernyataan_setuju', $proposal?->pernyataan_setuju))>
                    <label for="pernyataan" class="form-check-label small">
                        Penulis memastikan bahwa proposal penelitian ini telah memenuhi persyaratan substansi, format penulisan, serta ketentuan etika penelitian sebagaimana diatur dalam panduan hibah penelitian Universitas Batam. Apabila ditemukan ketidaksesuaian atau pelanggaran, penulis bersedia menerima konsekuensi sesuai aturan LPPM.
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="ri-save-line me-1"></i> Simpan {{ $isEdit ? 'Perubahan' : 'Draft' }}
                    </button>
                    @if ($isEdit && in_array($proposal->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                        <button type="button" class="btn btn-success" onclick="document.getElementById('formSubmit').submit()">
                            <i class="ri-send-plane-line me-1"></i> Submit Proposal
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>

    {{-- Dokumen Pendukung (di luar main form karena nested-form invalid) --}}
    @if ($isEdit)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="ri-attachment-2 text-primary me-2"></i>Dokumen Pendukung (Lampiran)</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Unggah berkas pendukung opsional: KTP Ketua, SK Mengajar, Pakta Integritas, MoU, dll. PDF / JPG / PNG &middot; maks 5 MB per file.</p>
                <table class="table table-sm align-middle mb-3">
                    <thead class="table-light">
                        <tr><th width="200">Jenis</th><th>Nama File</th><th width="120">Ukuran</th><th width="200">Tanggal</th><th width="120"></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumenList as $d)
                            <tr>
                                <td><span class="badge bg-secondary-subtle text-dark">{{ $d->jenis }}</span></td>
                                <td><a href="{{ asset('storage/' . $d->path) }}" target="_blank" class="text-decoration-none"><i class="ri-file-download-line me-1"></i>{{ $d->nama_file }}</a></td>
                                <td class="small text-muted">{{ number_format($d->ukuran / 1024, 1) }} KB</td>
                                <td class="small text-muted">{{ $d->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('dosen.penelitian.dokumen.delete', [$proposal, $d]) }}" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada dokumen pendukung.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <form method="POST" action="{{ route('dosen.penelitian.dokumen.upload', $proposal) }}" enctype="multipart/form-data" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label small">Jenis Dokumen</label>
                        <select name="jenis" class="form-select form-select-sm" required>
                            <option value="">-- Pilih --</option>
                            <option value="KTP Ketua">KTP Ketua</option>
                            <option value="SK Mengajar">SK Mengajar</option>
                            <option value="Pakta Integritas">Pakta Integritas</option>
                            <option value="Surat Tugas LPPM">Surat Tugas LPPM</option>
                            <option value="MoU">MoU / Kerjasama</option>
                            <option value="Roadmap Penelitian">Roadmap Penelitian</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">File <span class="text-muted">(PDF/JPG/PNG, maks 5MB)</span></label>
                        <input type="file" name="file" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ri-upload-line"></i> Unggah</button>
                    </div>
                </form>
            </div>
        </div>

        <form id="formSubmit" method="POST" action="{{ route('dosen.penelitian.submit', $proposal) }}" class="d-none">
            @csrf
        </form>
    @endif

    <template id="anggotaDosenTpl">
        <div class="row g-2 mb-2 anggota-row">
            <div class="col-md-6">
                <select name="anggota_dosen_id[]" class="form-select">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5"><input type="text" name="anggota_bidang_tugas[]" class="form-control" placeholder="Bidang tugas"></div>
            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.anggota-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
    </template>

    <template id="mahasiswaTpl">
        <div class="row g-2 mb-2 mahasiswa-row">
            <div class="col-md-3"><input type="text" name="mahasiswa_nama[]" class="form-control" placeholder="Nama"></div>
            <div class="col-md-2"><input type="text" name="mahasiswa_nim[]" class="form-control" placeholder="NIM"></div>
            <div class="col-md-3"><input type="text" name="mahasiswa_prodi[]" class="form-control" placeholder="Program Studi"></div>
            <div class="col-md-3"><input type="text" name="mahasiswa_bidang_tugas[]" class="form-control" placeholder="Bidang tugas"></div>
            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mahasiswa-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
    </template>

    <template id="mitraTpl">
        <div class="row g-2 mb-2 mitra-row align-items-start">
            <div class="col-md-3"><input type="text" name="mitra_nama[]" class="form-control" placeholder="Nama mitra"></div>
            <div class="col-md-3"><input type="text" name="mitra_pimpinan[]" class="form-control" placeholder="Pimpinan"></div>
            <div class="col-md-3"><textarea name="mitra_alamat[]" class="form-control" rows="1" placeholder="Alamat"></textarea></div>
            <div class="col-md-2"><textarea name="mitra_permasalahan[]" class="form-control" rows="1" placeholder="Permasalahan / kontribusi"></textarea></div>
            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mitra-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
    </template>

    <template id="luaranTpl">
        <tr class="luaran-row">
            <td><input type="number" min="1" max="5" name="luaran_tahun_ke[]" class="form-control form-control-sm" value="1"></td>
            <td>
                <select name="luaran_kategori[]" class="form-select form-select-sm">
                    <option value="wajib">Wajib</option>
                    <option value="tambahan">Tambahan</option>
                </select>
            </td>
            <td>
                <select name="luaran_jenis_id[]" class="form-select form-select-sm mb-1">
                    <option value="">-- Pilih dari daftar --</option>
                    @foreach ($jenisLuaranList as $j)
                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>
                <input type="text" name="luaran_jenis_text[]" class="form-control form-control-sm" placeholder="atau isi bebas">
            </td>
            <td><input type="text" name="luaran_status_target[]" class="form-control form-control-sm" placeholder="Submitted/Accepted/Published/Granted"></td>
            <td><textarea name="luaran_keterangan[]" rows="1" class="form-control form-control-sm"></textarea></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.luaran-row').remove()"><i class="ri-delete-bin-line"></i></button></td>
        </tr>
    </template>

    <template id="rabTpl">
        <tr class="rab-row">
            <td>
                <select name="rab_kategori_id[]" class="form-select form-select-sm rab-kategori">
                    @foreach ($kategoriRab as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="rab_komponen_id[]" class="form-select form-select-sm rab-komponen">
                    <option value="">-- Pilih --</option>
                    @foreach ($kategoriRab as $k)
                        @foreach ($k->komponen as $kp)
                            <option value="{{ $kp->id }}" data-kategori="{{ $k->id }}">{{ $kp->nama }}</option>
                        @endforeach
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="rab_item[]" class="form-control form-control-sm"></td>
            <td><input type="text" name="rab_justifikasi[]" class="form-control form-control-sm"></td>
            <td><input type="number" step="0.01" name="rab_kuantitas[]" class="form-control form-control-sm rab-qty" value="1"></td>
            <td><input type="text" name="rab_satuan[]" class="form-control form-control-sm"></td>
            <td><input type="number" name="rab_harga_satuan[]" class="form-control form-control-sm rab-harga" value="0"></td>
            <td class="rab-subtotal text-end small">Rp 0</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRab(this)"><i class="ri-delete-bin-line"></i></button></td>
        </tr>
    </template>
@endsection

@section('scripts')
<script>
function addAnggotaDosen() {
    const tpl = document.getElementById('anggotaDosenTpl').content.cloneNode(true);
    document.getElementById('anggotaDosen').appendChild(tpl);
}
function addMahasiswa() {
    const tpl = document.getElementById('mahasiswaTpl').content.cloneNode(true);
    document.getElementById('anggotaMahasiswa').appendChild(tpl);
}
function addRab() {
    const tpl = document.getElementById('rabTpl').content.cloneNode(true);
    document.getElementById('rabBody').appendChild(tpl);
    attachRabListeners();
}
function addMitra() {
    const tpl = document.getElementById('mitraTpl').content.cloneNode(true);
    document.getElementById('mitraList').appendChild(tpl);
}
function addLuaran() {
    const tpl = document.getElementById('luaranTpl').content.cloneNode(true);
    document.getElementById('luaranBody').appendChild(tpl);
}
function removeRab(btn) {
    btn.closest('tr').remove();
    updateRabTotal();
}
function formatRupiah(n) {
    return 'Rp ' + (n || 0).toLocaleString('id-ID');
}
function updateRabTotal() {
    let total = 0;
    document.querySelectorAll('.rab-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.rab-qty')?.value || 0);
        const harga = parseFloat(row.querySelector('.rab-harga')?.value || 0);
        const sub = Math.round(qty * harga);
        row.querySelector('.rab-subtotal').textContent = formatRupiah(sub);
        total += sub;
    });
    document.getElementById('rabTotal').textContent = formatRupiah(total);
}
function filterKomponen(kategoriSelect) {
    const row = kategoriSelect.closest('tr');
    const kategoriId = kategoriSelect.value;
    const komponenSelect = row.querySelector('.rab-komponen');
    const currentVal = komponenSelect.value;
    let firstMatch = '';
    komponenSelect.querySelectorAll('option').forEach(opt => {
        if (!opt.value) { opt.hidden = false; return; }
        const match = opt.dataset.kategori === kategoriId;
        opt.hidden = !match;
        if (match && !firstMatch) firstMatch = opt.value;
    });
    // jika current option tidak match, reset ke first match
    const cur = komponenSelect.querySelector(`option[value="${currentVal}"]`);
    if (!currentVal || (cur && cur.hidden)) komponenSelect.value = '';
}
function attachRabListeners() {
    document.querySelectorAll('.rab-qty, .rab-harga').forEach(el => {
        el.removeEventListener('input', updateRabTotal);
        el.addEventListener('input', updateRabTotal);
    });
    document.querySelectorAll('.rab-kategori').forEach(el => {
        el.removeEventListener('change', _rabKategoriHandler);
        el.addEventListener('change', _rabKategoriHandler);
        filterKomponen(el);
    });
}
function _rabKategoriHandler(e) { filterKomponen(e.target); }

// Word counter
function attachWordCounters() {
    document.querySelectorAll('.word-counter').forEach(el => {
        const max = parseInt(el.dataset.max);
        const help = document.createElement('small');
        help.className = 'text-muted d-block mt-1';
        el.after(help);
        const update = () => {
            const words = el.value.trim() ? el.value.trim().split(/\s+/).length : 0;
            help.textContent = `${words} / ${max} kata`;
            help.classList.toggle('text-danger', words > max);
        };
        el.addEventListener('input', update);
        update();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    attachRabListeners();
    updateRabTotal();
    attachWordCounters();
});
</script>
@endsection
