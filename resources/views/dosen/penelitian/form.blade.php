@extends('layouts.dosen')

@section('title', $proposal ? 'Edit Usulan Penelitian' : 'Ajukan Usulan Penelitian')

@php
    $activeNav = 'penelitian';
    $isEdit = (bool) $proposal;
    $action = $isEdit ? route('dosen.penelitian.update', $proposal) : route('dosen.penelitian.store');
    $jadwalText = $proposal?->jadwal_json['text'] ?? '';
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

        {{-- Section 5: Hasil yang Diharapkan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-target-line text-primary me-2"></i>5. Hasil yang Diharapkan</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Jenis Luaran</th>
                                <th>Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilJson as $i => $h)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><input type="text" name="hasil_diharapkan[{{ $i }}][jenis]" class="form-control form-control-sm" value="{{ $h['jenis'] ?? '' }}"></td>
                                    <td><input type="text" name="hasil_diharapkan[{{ $i }}][target]" class="form-control form-control-sm" value="{{ $h['target'] ?? '' }}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Section 6: Jadwal --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-calendar-line text-primary me-2"></i>6. Jadwal Penelitian</h6></div>
            <div class="card-body">
                <p class="text-muted small">Tuliskan jadwal kegiatan per bulan (contoh: <code>Bulan 1: Studi literatur. Bulan 2-3: Pengumpulan data. ...</code>)</p>
                <textarea name="jadwal_text" rows="6" class="form-control">{{ old('jadwal_text', $jadwalText) }}</textarea>
            </div>
        </div>

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
                                <th width="180">Kategori</th>
                                <th>Item / Material</th>
                                <th>Justifikasi</th>
                                <th width="80">Kuantitas</th>
                                <th width="80">Satuan</th>
                                <th width="140">Harga Satuan</th>
                                <th width="140">Sub Total</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="rabBody">
                            @foreach ($rabItems as $i => $r)
                                <tr class="rab-row">
                                    <td>
                                        <select name="rab_kategori_id[]" class="form-select form-select-sm">
                                            @foreach ($kategoriRab as $k)
                                                <option value="{{ $k->id }}" @selected($r->kategori_rab_id == $k->id)>{{ $k->nama }}</option>
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
                                <td colspan="6" class="text-end">TOTAL:</td>
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

    @if ($isEdit)
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

    <template id="rabTpl">
        <tr class="rab-row">
            <td>
                <select name="rab_kategori_id[]" class="form-select form-select-sm">
                    @foreach ($kategoriRab as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
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
function attachRabListeners() {
    document.querySelectorAll('.rab-qty, .rab-harga').forEach(el => {
        el.removeEventListener('input', updateRabTotal);
        el.addEventListener('input', updateRabTotal);
    });
}

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
