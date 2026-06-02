@extends('layouts.operator')

@section('title', 'Pengaturan')

@php
    $activeNav = 'pengaturan';

    // Keterangan bantuan per setting (ditampilkan di bawah input)
    $hints = [
        'lppm_ketua_nama'    => 'Nama lengkap + gelar Ketua LPPM. Muncul di Lembar Pengesahan PDF proposal (kolom "Mengetahui").',
        'lppm_ketua_nidn'    => 'NIDN/NIP Ketua LPPM, tampil di bawah nama pada Lembar Pengesahan.',
        'lppm_ketua_jabatan' => 'Contoh: "Ketua LPPM Universitas Batam". Tampil di atas nama penanda tangan.',
        'institusi_nama'     => 'Nama resmi institusi. Dipakai di judul Lembar Pengesahan & Surat Pernyataan.',
        'institusi_kota'     => 'Kota untuk format tanggal tanda tangan, mis. "Batam, 29 Mei 2026".',
        'institusi_kode'     => 'Kode singkat institusi untuk Nomor Registrasi proposal. Mengisi token {kode} di format di bawah.',
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Pengaturan Sistem</h4>
            <p class="text-muted small mb-0">Identitas Ketua LPPM, institusi, dan aset cetak (digunakan di lembar pengesahan PDF)</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('operator.pengaturan.update') }}" enctype="multipart/form-data">
        @csrf

        @foreach ($grouped as $grup => $items)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-settings-3-line text-primary me-2"></i>{{ ucfirst($grup) }}</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($items as $it)
                            <div class="{{ $it->kunci === 'proposal_no_format' ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label">
                                    {{ $it->label ?? $it->kunci }}
                                    @if (! empty($hints[$it->kunci]))
                                        <i class="ri-question-line text-muted" data-bs-toggle="tooltip" title="{{ $hints[$it->kunci] }}"></i>
                                    @endif
                                </label>
                                @if ($it->tipe === 'image')
                                    @if ($it->nilai)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $it->nilai) }}" style="max-height:80px;" class="border rounded">
                                        </div>
                                    @endif
                                    @if ($it->kunci === 'lppm_ttd_path')
                                        <input type="file" name="lppm_ttd" class="form-control" accept="image/png,image/jpeg">
                                        <small class="text-muted">Tanda tangan (PNG transparan disarankan, maks 1MB). Muncul di Lembar Pengesahan PDF.</small>
                                    @elseif ($it->kunci === 'kop_kiri_path')
                                        <input type="file" name="kop_kiri" class="form-control" accept="image/png,image/jpeg">
                                        <small class="text-muted">PNG transparan disarankan, maks 1MB. Tampil di <strong>pojok kiri atas</strong> header semua PDF proposal.</small>
                                    @elseif ($it->kunci === 'kop_kanan_path')
                                        <input type="file" name="kop_kanan" class="form-control" accept="image/png,image/jpeg">
                                        <small class="text-muted">PNG transparan disarankan, maks 1MB. Tampil di <strong>pojok kanan atas</strong> header semua PDF proposal.</small>
                                    @endif
                                @elseif ($it->kunci === 'proposal_no_format')
                                    <input type="text" name="nilai[{{ $it->kunci }}]" class="form-control font-monospace"
                                        value="{{ old('nilai.' . $it->kunci, $it->nilai) }}">
                                    <div class="alert alert-info small mt-2 mb-0">
                                        <div class="fw-semibold mb-1"><i class="ri-information-line"></i> Cara kerja format nomor registrasi</div>
                                        <p class="mb-2">Nomor registrasi dibuat <strong>otomatis saat proposal di-submit</strong>. Gunakan token berikut:</p>
                                        <table class="table table-sm table-borderless mb-2" style="font-size:.8rem;">
                                            <tr><td width="90"><code>{kode}</code></td><td>Kode institusi (dari field "Kode Institusi" di atas)</td><td class="text-muted">LPPM-UNIBA</td></tr>
                                            <tr><td><code>{jenis}</code></td><td>Jenis hibah — otomatis: <code>PNL</code> (Penelitian) / <code>PKM</code></td><td class="text-muted">PNL</td></tr>
                                            <tr><td><code>{tahun}</code></td><td>Tahun periode hibah</td><td class="text-muted">2026</td></tr>
                                            <tr><td><code>{seq:3}</code></td><td>Nomor urut, 3 digit (per jenis &amp; tahun). Angka 3 bisa diganti, mis. <code>{seq:4}</code> = 0001</td><td class="text-muted">001</td></tr>
                                        </table>
                                        <div>Contoh hasil dari <code>{kode}/{jenis}/{tahun}/{seq:3}</code> →
                                            <span class="badge bg-primary">LPPM-UNIBA/PNL/2026/001</span>
                                        </div>
                                        <div class="mt-2 text-muted">Berpengaruh di: <strong>header PDF</strong>, <strong>Lembar Pengesahan</strong>, halaman detail proposal, dan kolom nomor di rekap. Mengubah format <u>tidak</u> mengubah nomor proposal lama yang sudah terbit.</div>
                                    </div>
                                @else
                                    <input type="text" name="nilai[{{ $it->kunci }}]" class="form-control"
                                        value="{{ old('nilai.' . $it->kunci, $it->nilai) }}">
                                    @if (! empty($hints[$it->kunci]))
                                        <small class="text-muted">{{ $hints[$it->kunci] }}</small>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>
@endsection
