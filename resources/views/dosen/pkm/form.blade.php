@extends('layouts.dosen')

@section('title', $proposal ? 'Edit Usulan PKM' : 'Ajukan Usulan PKM')

@php
    $activeNav = 'pengabdian';
    $isEdit = (bool) $proposal;
    $action = $isEdit ? route('dosen.pkm.update', $proposal) : route('dosen.pkm.store');
    $jadwalText = $proposal?->jadwal_json['text'] ?? '';
    $hasilJson = $proposal?->hasil_diharapkan_json ?? [
        ['jenis' => 'Publikasi ilmiah di Jurnal Scopus/Sinta (1-4)', 'target' => 'Published/LOA'],
        ['jenis' => 'Peningkatan pengetahuan/keahlian mitra PKM', 'target' => 'Ada'],
        ['jenis' => 'Hak Kekayaan Intelektual', 'target' => 'Terdaftar HKI'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $isEdit ? 'Edit' : 'Ajukan' }} Usulan PKM</h4>
            <p class="text-muted small mb-0">{{ $skema->nama }} &middot; {{ $periode->nama }} &middot; Maks Rp {{ number_format($skema->max_anggaran, 0, ',', '.') }}</p>
        </div>
        <a href="{{ route('dosen.pkm.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="formProposal">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        {{-- Section 1: Identitas Pengusul --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-team-line text-primary me-2"></i>1. Identitas Pengusul PKM</h6></div>
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
                    @foreach ($anggotaDosen as $a)
                        <div class="row g-2 mb-2 anggota-row">
                            <div class="col-md-6">
                                <select name="anggota_dosen_id[]" class="form-select">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosenList as $d)
                                        <option value="{{ $d->id }}" @selected($a->dosen_id == $d->id)>{{ $d->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5"><input type="text" name="anggota_bidang_tugas[]" class="form-control" placeholder="Bidang tugas" value="{{ $a->bidang_tugas }}"></div>
                            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.anggota-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                    @endforeach
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

                <h6 class="mt-4">Mitra Kerjasama <span class="text-danger">*</span></h6>
                <p class="text-muted small mb-2">Wajib minimal 1 mitra untuk PKM.</p>
                <div id="mitraList">
                    @foreach ($mitraList as $m)
                        <div class="card mb-2 mitra-row">
                            <div class="card-body p-3">
                                <div class="row g-2">
                                    <div class="col-md-5"><input type="text" name="mitra_nama[]" class="form-control" placeholder="Nama Mitra" value="{{ $m->nama_mitra }}"></div>
                                    <div class="col-md-5"><input type="text" name="mitra_pimpinan[]" class="form-control" placeholder="Pimpinan Mitra" value="{{ $m->pimpinan_mitra }}"></div>
                                    <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mitra-row').remove()"><i class="ri-delete-bin-line"></i> Hapus</button></div>
                                    <div class="col-md-12"><input type="text" name="mitra_alamat[]" class="form-control" placeholder="Alamat Mitra" value="{{ $m->alamat_mitra }}"></div>
                                    <div class="col-md-12"><textarea name="mitra_permasalahan[]" rows="2" class="form-control" placeholder="Permasalahan yang dihadapi mitra">{{ $m->permasalahan_mitra }}</textarea></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMitra()"><i class="ri-add-line"></i> Tambah Mitra</button>
            </div>
        </div>

        {{-- Section 2: Identitas Proposal --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-file-text-line text-primary me-2"></i>2. Identitas Proposal</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-10">
                        <label class="form-label">Judul PKM <span class="text-danger">*</span> <span class="text-muted small">(maks 20 kata)</span></label>
                        <input type="text" name="judul" required class="form-control" value="{{ old('judul', $proposal?->judul) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Durasi (bln) <span class="text-danger">*</span></label>
                        <input type="number" name="durasi_bulan" required min="1" max="{{ $skema->max_durasi_bulan }}" class="form-control" value="{{ old('durasi_bulan', $proposal?->durasi_bulan ?? 8) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Ringkasan <span class="text-muted small">(maks 300 kata)</span></label>
                        <textarea name="ringkasan" rows="4" class="form-control word-counter" data-max="300">{{ old('ringkasan', $proposal?->ringkasan) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Kata Kunci <span class="text-muted small">(5 kata dipisahkan ;)</span></label>
                        <input type="text" name="kata_kunci" class="form-control" value="{{ old('kata_kunci', $proposal?->kata_kunci) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Pendahuluan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-book-open-line text-primary me-2"></i>3. Pendahuluan</h6></div>
            <div class="card-body">
                <p class="text-muted small">Analisis situasi dan permasalahan mitra. Uraikan secara komprehensif kondisi mitra sasaran (potensi, permasalahan, kewilayahan). Sitasi pakai Mendeley.</p>
                <textarea name="pendahuluan" rows="10" class="form-control word-counter" data-max="1000">{{ old('pendahuluan', $proposal?->pendahuluan) }}</textarea>
            </div>
        </div>

        {{-- Section 4: Permasalahan & Solusi (PKM-specific) --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-lightbulb-line text-primary me-2"></i>4. Permasalahan & Solusi <span class="text-muted small">(maks 500 kata)</span></h6></div>
            <div class="card-body">
                <p class="text-muted small">Permasalahan prioritas minimal 2 aspek per mitra. Uraikan dalam poin-poin sesuai kesepakatan dengan mitra.</p>
                <textarea name="permasalahan_solusi" rows="8" class="form-control word-counter" data-max="500">{{ old('permasalahan_solusi', $proposal?->permasalahan_solusi) }}</textarea>
            </div>
        </div>

        {{-- Section 5: Metode --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-flask-line text-primary me-2"></i>5. Metode Pelaksanaan <span class="text-muted small">(maks 1500 kata)</span></h6></div>
            <div class="card-body">
                <p class="text-muted small">Tahapan pelaksanaan, setidaknya memuat: <strong>a) Sosialisasi, b) Pelatihan, c) Penerapan Teknologi, d) Pendampingan & Evaluasi, e) Keberlanjutan Program</strong>.</p>
                <textarea name="metode" rows="10" class="form-control word-counter" data-max="1500">{{ old('metode', $proposal?->metode) }}</textarea>

                <div class="mt-3">
                    <label class="form-label">Diagram Alir Kegiatan <span class="text-muted small">(opsional JPG/PNG, maks 2MB)</span></label>
                    <input type="file" name="metode_diagram" class="form-control" accept="image/jpeg,image/png">
                    @if ($proposal?->metode_diagram_path)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $proposal->metode_diagram_path) }}" target="_blank">lihat</a></small>
                    @endif
                </div>
            </div>
        </div>

        {{-- Section 6: Hasil Diharapkan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-target-line text-primary me-2"></i>6. Hasil yang Diharapkan</h6></div>
            <div class="card-body">
                <table class="table align-middle">
                    <thead class="table-light"><tr><th width="50">#</th><th>Jenis Luaran</th><th>Target</th></tr></thead>
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

        {{-- Section 7: Jadwal --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-calendar-line text-primary me-2"></i>7. Jadwal PKM</h6></div>
            <div class="card-body">
                <textarea name="jadwal_text" rows="6" class="form-control" placeholder="Contoh: Bulan 1: Sosialisasi. Bulan 2: Pelatihan. Bulan 3: Penerapan. ...">{{ old('jadwal_text', $jadwalText) }}</textarea>
            </div>
        </div>

        {{-- Section 8: Daftar Pustaka --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-book-line text-primary me-2"></i>8. Daftar Pustaka <span class="text-muted small">(maks 500 kata)</span></h6></div>
            <div class="card-body">
                <textarea name="daftar_pustaka" rows="8" class="form-control word-counter" data-max="500">{{ old('daftar_pustaka', $proposal?->daftar_pustaka) }}</textarea>
            </div>
        </div>

        {{-- Section 9: RAB --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0"><i class="ri-money-dollar-circle-line text-primary me-2"></i>9. Rencana Anggaran Biaya</h6>
                <span class="text-muted small">Maks: Rp {{ number_format($skema->max_anggaran, 0, ',', '.') }}</span>
            </div>
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="180">Kategori</th>
                            <th>Item</th>
                            <th>Justifikasi</th>
                            <th width="80">Qty</th>
                            <th width="80">Satuan</th>
                            <th width="140">Harga Satuan</th>
                            <th width="140">Sub Total</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="rabBody">
                        @foreach ($rabItems as $r)
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
                    <tfoot><tr class="fw-bold"><td colspan="6" class="text-end">TOTAL:</td><td id="rabTotal" class="text-end">Rp 0</td><td></td></tr></tfoot>
                </table>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRab()"><i class="ri-add-line"></i> Tambah Baris RAB</button>
            </div>
        </div>

        {{-- Section 10: Pernyataan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="form-check mb-3">
                    <input type="checkbox" name="pernyataan_setuju" id="pernyataan" value="1" class="form-check-input" @checked(old('pernyataan_setuju', $proposal?->pernyataan_setuju))>
                    <label for="pernyataan" class="form-check-label small">
                        Penulis memastikan bahwa proposal PKM ini telah memenuhi persyaratan substansi, format penulisan, serta ketentuan etika sebagaimana diatur dalam panduan hibah PKM Universitas Batam.
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-primary"><i class="ri-save-line me-1"></i> Simpan {{ $isEdit ? 'Perubahan' : 'Draft' }}</button>
                    @if ($isEdit && in_array($proposal->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                        <button type="button" class="btn btn-success" onclick="document.getElementById('formSubmit').submit()">
                            <i class="ri-send-plane-line me-1"></i> Submit Proposal PKM
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @if ($isEdit)
        <form id="formSubmit" method="POST" action="{{ route('dosen.pkm.submit', $proposal) }}" class="d-none">@csrf</form>
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
        <div class="card mb-2 mitra-row">
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-5"><input type="text" name="mitra_nama[]" class="form-control" placeholder="Nama Mitra"></div>
                    <div class="col-md-5"><input type="text" name="mitra_pimpinan[]" class="form-control" placeholder="Pimpinan Mitra"></div>
                    <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.mitra-row').remove()"><i class="ri-delete-bin-line"></i> Hapus</button></div>
                    <div class="col-md-12"><input type="text" name="mitra_alamat[]" class="form-control" placeholder="Alamat Mitra"></div>
                    <div class="col-md-12"><textarea name="mitra_permasalahan[]" rows="2" class="form-control" placeholder="Permasalahan yang dihadapi mitra"></textarea></div>
                </div>
            </div>
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
function addAnggotaDosen() { document.getElementById('anggotaDosen').appendChild(document.getElementById('anggotaDosenTpl').content.cloneNode(true)); }
function addMahasiswa() { document.getElementById('anggotaMahasiswa').appendChild(document.getElementById('mahasiswaTpl').content.cloneNode(true)); }
function addMitra() { document.getElementById('mitraList').appendChild(document.getElementById('mitraTpl').content.cloneNode(true)); }
function addRab() { document.getElementById('rabBody').appendChild(document.getElementById('rabTpl').content.cloneNode(true)); attachRabListeners(); }
function removeRab(btn) { btn.closest('tr').remove(); updateRabTotal(); }
function formatRupiah(n) { return 'Rp ' + (n || 0).toLocaleString('id-ID'); }
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
