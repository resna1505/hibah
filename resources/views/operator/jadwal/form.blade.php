@extends('layouts.operator')

@section('title', $periode ? 'Edit Periode Hibah' : 'Periode Hibah Baru')

@php
    $activeNav = 'jadwal';
    $isEdit = (bool) $periode;
    $action = $isEdit ? route('operator.jadwal.update', $periode) : route('operator.jadwal.store');
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $isEdit ? 'Edit' : 'Buat' }} Periode Hibah</h4>
            <p class="text-muted small mb-0">Atur tahun, status, tahapan, dan jadwal laporan</p>
        </div>
        <a href="{{ route('operator.jadwal.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    <form method="POST" action="{{ $action }}">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        {{-- Section 1: Periode Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-calendar-line text-primary me-2"></i>Identitas Periode</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" required min="2020" max="2100"
                            class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', $periode?->tahun ?? now()->year) }}">
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Nama Periode <span class="text-danger">*</span></label>
                        <input type="text" name="nama" required class="form-control"
                            value="{{ old('nama', $periode?->nama ?? 'Hibah Internal ' . now()->year) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" required class="form-select">
                            @foreach (['draft' => 'Draft', 'aktif' => 'Aktif', 'selesai' => 'Selesai'] as $val => $label)
                                <option value="{{ $val }}" @selected(old('status', $periode?->status ?? 'draft') === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $periode?->keterangan) }}</textarea>
                    </div>
                </div>
                @if (! $isEdit)
                    <div class="alert alert-info mt-3 mb-0 small">
                        <i class="ri-information-line me-1"></i> Mengaktifkan periode ini akan mengubah periode aktif lain menjadi <strong>Selesai</strong>.
                    </div>
                @endif
            </div>
        </div>

        {{-- Section 2: Jadwal Tahapan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><h6 class="mb-0"><i class="ri-flow-chart text-primary me-2"></i>Jadwal Tahapan Hibah</h6></div>
            <div class="card-body">
                <p class="text-muted small">6 tahapan default: Pengajuan → Review → Revisi → Penetapan → Pengumuman → Pelaksanaan. Atur tanggal & status masing-masing.</p>
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="40">#</th>
                            <th>Tahapan</th>
                            <th width="180">Tanggal Mulai</th>
                            <th width="180">Tanggal Selesai</th>
                            <th width="210">Batas Submit (WIB)</th>
                            <th width="160">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tahapanHibah as $t)
                            @php
                                $existing = $jadwalByKode[$t->kode] ?? null;
                                $defaultMulai = match ($t->kode) {
                                    'pengajuan'  => now()->subDays(30)->toDateString(),
                                    'review'     => now()->subDays(14)->toDateString(),
                                    'revisi'     => now()->addDays(21)->toDateString(),
                                    'penetapan'  => now()->addDays(36)->toDateString(),
                                    'pengumuman' => now()->addDays(43)->toDateString(),
                                    'pelaksanaan'=> now()->addDays(45)->toDateString(),
                                    default      => now()->toDateString(),
                                };
                                $defaultSelesai = match ($t->kode) {
                                    'pengajuan'  => now()->addDays(15)->toDateString(),
                                    'review'     => now()->addDays(20)->toDateString(),
                                    'revisi'     => now()->addDays(35)->toDateString(),
                                    'penetapan'  => now()->addDays(40)->toDateString(),
                                    'pengumuman' => now()->addDays(43)->toDateString(),
                                    'pelaksanaan'=> now()->addDays(225)->toDateString(),
                                    default      => now()->addDays(7)->toDateString(),
                                };
                            @endphp
                            <tr>
                                <td>{{ $t->urutan }}</td>
                                <td><strong>{{ $t->nama }}</strong>@if ($t->deskripsi)<br><small class="text-muted">{{ $t->deskripsi }}</small>@endif</td>
                                <td>
                                    <input type="hidden" name="tahapan_id[]" value="{{ $t->id }}">
                                    <input type="date" name="tgl_mulai[]" required class="form-control form-control-sm"
                                        value="{{ $existing?->tgl_mulai?->toDateString() ?? $defaultMulai }}">
                                </td>
                                <td>
                                    <input type="date" name="tgl_selesai[]" required class="form-control form-control-sm"
                                        value="{{ $existing?->tgl_selesai?->toDateString() ?? $defaultSelesai }}">
                                </td>
                                <td>
                                    @if ($t->kode === 'pengajuan')
                                        <input type="datetime-local" name="batas_submit[]" class="form-control form-control-sm"
                                            value="{{ $existing?->batas_submit?->copy()->setTimezone(\App\Models\Transaction\JadwalTahapan::TZ_LOKAL)->format('Y-m-d\TH:i') }}">
                                        <small class="text-muted" style="font-size:.7rem;">
                                            Lewat jam ini proposal tidak bisa di-submit.
                                            Kosongkan = pakai akhir hari Tanggal Selesai (23:59).
                                        </small>
                                    @else
                                        {{-- Kolom hanya relevan untuk tahapan pengajuan; kirim placeholder
                                             agar indeks array tetap sejajar dengan tahapan_id[]. --}}
                                        <input type="hidden" name="batas_submit[]" value="">
                                        <span class="text-muted small">&mdash;</span>
                                    @endif
                                </td>
                                <td>
                                    <select name="tahapan_status[]" class="form-select form-select-sm">
                                        @foreach (['belum_mulai' => 'Belum Mulai', 'berjalan' => 'Berjalan', 'selesai' => 'Selesai'] as $val => $label)
                                            <option value="{{ $val }}" @selected(($existing?->status ?? 'belum_mulai') === $val)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section 3: Periode Laporan Kemajuan --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0"><i class="ri-file-list-3-line text-primary me-2"></i>Periode Laporan Kemajuan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addLaporan()"><i class="ri-add-line"></i> Tambah</button>
            </div>
            <div class="card-body">
                <p class="text-muted small">Atur jadwal pengumpulan laporan kemajuan per skema (Penelitian / PKM). Contoh: "Kemajuan 50%", "Kemajuan 100%".</p>
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Skema</th>
                            <th>Label Laporan</th>
                            <th width="200">Batas Unggah</th>
                            <th width="60"></th>
                        </tr>
                    </thead>
                    <tbody id="laporanBody">
                        @forelse ($periodeLaporan as $pl)
                            <tr class="laporan-row">
                                <td>
                                    <select name="laporan_skema[]" class="form-select form-select-sm">
                                        <option value="penelitian" @selected($pl->skema_jenis === 'penelitian')>Penelitian</option>
                                        <option value="pkm" @selected($pl->skema_jenis === 'pkm')>PKM</option>
                                    </select>
                                </td>
                                <td><input type="text" name="laporan_label[]" class="form-control form-control-sm" value="{{ $pl->label }}"></td>
                                <td><input type="date" name="laporan_batas[]" class="form-control form-control-sm" value="{{ $pl->batas_unggah->toDateString() }}"></td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="ri-delete-bin-line"></i></button></td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('operator.jadwal.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Simpan {{ $isEdit ? 'Perubahan' : 'Periode' }}</button>
        </div>
    </form>

    <template id="laporanTpl">
        <tr class="laporan-row">
            <td>
                <select name="laporan_skema[]" class="form-select form-select-sm">
                    <option value="penelitian">Penelitian</option>
                    <option value="pkm">PKM</option>
                </select>
            </td>
            <td><input type="text" name="laporan_label[]" class="form-control form-control-sm" placeholder="Kemajuan 50%"></td>
            <td><input type="date" name="laporan_batas[]" class="form-control form-control-sm"></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="ri-delete-bin-line"></i></button></td>
        </tr>
    </template>
@endsection

@section('scripts')
<script>
function addLaporan() {
    document.getElementById('laporanBody').appendChild(document.getElementById('laporanTpl').content.cloneNode(true));
}
</script>
@endsection
