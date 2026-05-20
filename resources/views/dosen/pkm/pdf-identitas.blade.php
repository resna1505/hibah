<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Identitas Proposal PKM — {{ $p->judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11pt; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px; }
        .header h2 { margin: 0; font-size: 14pt; }
        .header h3 { margin: 4px 0 0; font-size: 12pt; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 10pt; }
        table.bordered td, table.bordered th { border: 1px solid #444; padding: 5px 7px; vertical-align: top; }
        table.bordered th { background: #f1f3f8; }
        h4 { font-size: 11pt; margin: 14px 0 6px; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
        .small { font-size: 9.5pt; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .text-muted { color: #777; }
        p { margin: 4px 0; text-align: justify; }
    </style>
</head>
<body>

@php
    $kopPath = \App\Models\Master\Pengaturan::get('lppm_kop_path');
    $kopFile = $kopPath ? storage_path('app/public/' . $kopPath) : null;
@endphp
<div class="header">
    @if ($kopFile && file_exists($kopFile))
        <img src="{{ $kopFile }}" style="max-width: 100%; max-height: 90px; margin-bottom: 4px;">
    @else
        <h2>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
        <h3>UNIVERSITAS BATAM</h3>
    @endif
    <h3 style="margin-top:6px;">IDENTITAS DAN URAIAN UMUM PROPOSAL PKM</h3>
    @if ($p->no_registrasi)
        <p style="margin: 4px 0; font-size: 10pt;">No. Registrasi: <strong>{{ $p->no_registrasi }}</strong></p>
    @endif
</div>

<h4>1. Judul PKM</h4>
<table class="bordered">
    <tr><td colspan="3"><strong>{{ $p->judul }}</strong></td></tr>
    <tr>
        <td width="33%"><small>Program Studi</small><br>{{ $p->ketua->prodi?->nama ?? '-' }}</td>
        <td width="33%"><small>Fakultas</small><br>{{ $p->ketua->fakultas?->nama ?? '-' }}</td>
        <td width="34%"><small>Rumpun Ilmu</small><br>{{ $p->ketua->prodi?->fakultas?->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td><small>Skema Hibah</small><br>{{ $p->skemaHibah->nama }}</td>
        <td><small>Total Usulan Dana</small><br>Rp {{ number_format($totalRab, 0, ',', '.') }}</td>
        <td><small>Lama Kegiatan</small><br>{{ $p->durasi_bulan }} bulan</td>
    </tr>
</table>

<h4>2. Identitas Pengusul</h4>
<table class="bordered">
    <thead>
        <tr>
            <th width="28%">Nama, Peran</th>
            <th width="10%">Jenis</th>
            <th width="20%">Program Studi/Bagian</th>
            <th width="27%">Bidang Tugas</th>
            <th width="15%">ID Sinta</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>{{ $p->ketua->nama_lengkap }}</strong><br><small>{{ $p->ketua->nidn ?? '' }}</small><br><em>Ketua Pengusul</em></td>
            <td>Dosen</td>
            <td>{{ $p->ketua->prodi?->nama }}</td>
            <td>Membuat perencanaan PKM, menyusun proposal, dan mengarahkan pelaksanaan kegiatan.</td>
            <td>{{ $p->ketua->sinta_id ?? '-' }}</td>
        </tr>
        @foreach ($p->anggota as $a)
            <tr>
                @if ($a->peran === 'anggota_dosen')
                    <td><strong>{{ $a->dosen?->nama_lengkap }}</strong><br><small>{{ $a->dosen?->nidn ?? '' }}</small><br><em>Anggota Pengusul</em></td>
                    <td>Dosen</td>
                    <td>{{ $a->dosen?->prodi?->nama ?? '-' }}</td>
                @else
                    <td><strong>{{ $a->nama_mahasiswa }}</strong><br><small>{{ $a->nim }}</small><br><em>Mahasiswa</em></td>
                    <td>Mahasiswa</td>
                    <td>{{ $a->program_studi ?? '-' }}</td>
                @endif
                <td>{{ $a->bidang_tugas ?? '-' }}</td>
                <td>{{ $a->dosen?->sinta_id ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($p->mitra->isNotEmpty())
    <h4>3. Mitra Kerjasama</h4>
    <table class="bordered">
        <thead><tr><th>Nama Mitra</th><th>Pimpinan</th><th>Alamat</th><th>Permasalahan</th></tr></thead>
        <tbody>
            @foreach ($p->mitra as $m)
                <tr>
                    <td>{{ $m->nama_mitra }}</td>
                    <td>{{ $m->pimpinan_mitra }}</td>
                    <td>{{ $m->alamat_mitra }}</td>
                    <td>{{ $m->permasalahan_mitra }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if ($p->bidangStrategis)
    <h4>4. Bidang Strategis</h4>
    <table class="bordered">
        <tr>
            <td width="30%"><small>Bidang Strategis</small></td>
            <td><strong>{{ $p->bidangStrategis->kode }}. {{ $p->bidangStrategis->nama }}</strong></td>
        </tr>
        @if ($p->rumusan_masalah_bidang)
            <tr><td><small>Rumusan Masalah Bidang</small></td><td style="white-space: pre-wrap;">{{ $p->rumusan_masalah_bidang }}</td></tr>
        @endif
        @if ($p->uraian_bidang)
            <tr><td><small>Uraian Bidang</small></td><td style="white-space: pre-wrap;">{{ $p->uraian_bidang }}</td></tr>
        @endif
    </table>
@endif

@if ($p->ringkasan)
    <h4>5. Ringkasan</h4>
    <p>{{ $p->ringkasan }}</p>
    @if ($p->kata_kunci)<p><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>@endif
@endif

@if ($p->rencanaLuaran->isNotEmpty())
    <h4>6. Rencana Luaran</h4>
    <table class="bordered small">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tahun ke-</th>
                <th width="12%">Kategori</th>
                <th>Jenis Luaran</th>
                <th width="18%">Status Target Capaian</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($p->rencanaLuaran as $rl)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rl->tahun_ke }}</td>
                    <td>{{ ucfirst($rl->kategori) }}</td>
                    <td>{{ $rl->jenisLuaran?->nama ?? $rl->jenis_luaran_text ?? '-' }}</td>
                    <td>{{ $rl->status_target ?? '-' }}</td>
                    <td>{{ $rl->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if ($p->dokumen->isNotEmpty())
    <h4>7. Daftar Dokumen Pendukung</h4>
    <table class="bordered small">
        <thead><tr><th width="5%">No</th><th width="30%">Jenis</th><th>Nama File</th><th width="15%">Ukuran</th></tr></thead>
        <tbody>
            @foreach ($p->dokumen as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->jenis }}</td>
                    <td>{{ $d->nama_file }}</td>
                    <td>{{ number_format($d->ukuran / 1024, 1) }} KB</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- Halaman Persetujuan LPPM --}}
@php
    use App\Models\Master\Pengaturan;
    $lppmNama    = Pengaturan::get('lppm_ketua_nama', 'Ketua LPPM');
    $lppmNidn    = Pengaturan::get('lppm_ketua_nidn', '-');
    $lppmJabatan = Pengaturan::get('lppm_ketua_jabatan', 'Ketua LPPM');
    $institusi   = Pengaturan::get('institusi_nama', 'Universitas Batam');
    $kota        = Pengaturan::get('institusi_kota', 'Batam');
    $ttdPath     = Pengaturan::get('lppm_ttd_path');
    $ttdFile     = $ttdPath ? storage_path('app/public/' . $ttdPath) : null;
@endphp

<div style="page-break-before: always;"></div>
<div class="header">
    <h2>LEMBAR PENGESAHAN PROPOSAL PENGABDIAN KEPADA MASYARAKAT</h2>
    <h3>{{ strtoupper($institusi) }}</h3>
</div>

<table class="bordered">
    @if ($p->no_registrasi)
        <tr><td width="35%"><small>No. Registrasi</small></td><td><strong>{{ $p->no_registrasi }}</strong></td></tr>
    @endif
    <tr><td width="35%"><small>Judul PKM</small></td><td><strong>{{ $p->judul }}</strong></td></tr>
    <tr><td><small>Skema Hibah</small></td><td>{{ $p->skemaHibah->nama }}</td></tr>
    <tr><td><small>Bidang Strategis</small></td><td>{{ $p->bidangStrategis?->nama ?? '-' }}</td></tr>
    <tr><td><small>Ketua Pengusul</small></td><td>{{ $p->ketua->nama_lengkap }} (NIDN. {{ $p->ketua->nidn ?? '-' }})</td></tr>
    <tr><td><small>Program Studi / Fakultas</small></td><td>{{ $p->ketua->prodi?->nama ?? '-' }} / {{ $p->ketua->fakultas?->nama ?? '-' }}</td></tr>
    <tr><td><small>Jumlah Anggota</small></td><td>{{ $p->anggota->count() }} orang</td></tr>
    <tr><td><small>Jumlah Mitra</small></td><td>{{ $p->mitra->count() }} mitra</td></tr>
    <tr><td><small>Lama Kegiatan</small></td><td>{{ $p->durasi_bulan }} bulan</td></tr>
    <tr><td><small>Total Usulan Dana</small></td><td><strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></td></tr>
</table>

<table style="margin-top:30px;">
    <tr>
        <td width="50%" style="vertical-align: top; text-align: center;">
            <p>Mengetahui,<br>{{ $lppmJabatan }}</p>
            @if ($ttdFile && file_exists($ttdFile))
                <img src="{{ $ttdFile }}" style="height:70px; margin: 4px 0;">
            @else
                <br><br><br><br>
            @endif
            <p><strong><u>{{ $lppmNama }}</u></strong><br>NIDN/NIP. {{ $lppmNidn }}</p>
        </td>
        <td width="50%" style="vertical-align: top; text-align: center;">
            <p>{{ $kota }}, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}<br>Ketua Pengusul,</p>
            @php $ketuaTtd = $p->ketua->ttd_path ? storage_path('app/public/' . $p->ketua->ttd_path) : null; @endphp
            @if ($ketuaTtd && file_exists($ketuaTtd))
                <img src="{{ $ketuaTtd }}" style="height:70px; margin: 4px 0;">
            @else
                <br><br><br><br>
            @endif
            <p><strong><u>{{ $p->ketua->nama_lengkap }}</u></strong><br>NIDN. {{ $p->ketua->nidn ?? '-' }}</p>
        </td>
    </tr>
</table>

</body>
</html>
