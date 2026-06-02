<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Proposal PKM — {{ $p->judul }}</title>
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
        .signature { margin-top: 24px; }
    </style>
</head>
<body>

<div class="header">
    @include('dosen._shared.pdf-kop')
    <h3 style="margin-top:6px;">PROPOSAL PENGABDIAN KEPADA MASYARAKAT</h3>
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

{{-- Bidang Strategis --}}
@if ($p->bidangStrategis)
    <h4>3b. Bidang Strategis</h4>
    <table class="bordered">
        <tr>
            <td width="30%"><small>Bidang Strategis</small></td>
            <td><strong>{{ $p->bidangStrategis->kode }}. {{ $p->bidangStrategis->nama }}</strong></td>
        </tr>
        @if ($p->rumusan_masalah_bidang)
            <tr>
                <td><small>Rumusan Masalah Bidang</small></td>
                <td style="white-space: pre-wrap;">{{ $p->rumusan_masalah_bidang }}</td>
            </tr>
        @endif
        @if ($p->uraian_bidang)
            <tr>
                <td><small>Uraian Bidang</small></td>
                <td style="white-space: pre-wrap;">{{ $p->uraian_bidang }}</td>
            </tr>
        @endif
    </table>
@endif

@if ($p->ringkasan)
    <h4>4. Ringkasan</h4>
    <p>{{ $p->ringkasan }}</p>
    @if ($p->kata_kunci)<p><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>@endif
@endif

@if ($p->pendahuluan)
    <h4>5. Pendahuluan</h4>
    <p style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p>
@endif

@if ($p->permasalahan_solusi)
    <h4>6. Permasalahan & Solusi</h4>
    <p style="white-space: pre-wrap;">{{ $p->permasalahan_solusi }}</p>
@endif

@if ($p->metode)
    <h4>7. Metode Pelaksanaan</h4>
    <p style="white-space: pre-wrap;">{{ $p->metode }}</p>
    @if ($p->metode_diagram_path && file_exists(storage_path('app/public/' . $p->metode_diagram_path)))
        <p class="text-center">
            <img src="{{ storage_path('app/public/' . $p->metode_diagram_path) }}" style="max-width:80%; max-height:300px;">
            <br><small class="text-muted">Diagram Alir Kegiatan</small>
        </p>
    @endif
@endif

@if ($p->rencanaLuaran->isNotEmpty())
    <h4>8. Rencana Luaran</h4>
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

@if ($p->jadwal_json && (! empty($p->jadwal_json['rows']) || ! empty($p->jadwal_json['text'])))
    <h4>9. Jadwal Pelaksanaan</h4>
    @include('dosen._shared.jadwal-display', ['p' => $p, 'variant' => 'pdf'])
@endif

@if ($p->daftar_pustaka)
    <h4>10. Daftar Pustaka</h4>
    <p style="white-space: pre-wrap;" class="small">{{ $p->daftar_pustaka }}</p>
@endif

@if ($p->rab->isNotEmpty())
    <h4>11. Rencana Anggaran Biaya (RAB)</h4>
    @php $rabByKategori = $p->rab->groupBy(fn($r) => $r->kategori?->nama ?? '-'); @endphp
    @foreach ($rabByKategori as $namaKategori => $items)
        <p style="margin-top:8px;"><strong>{{ $loop->iteration }}. {{ $namaKategori }}</strong></p>
        <table class="bordered small">
            <thead>
                <tr>
                    <th width="20%">Komponen</th><th>Item</th><th width="22%">Justifikasi</th>
                    <th width="8%" class="text-end">Qty</th><th width="7%">Satuan</th>
                    <th width="13%" class="text-end">Harga Satuan</th><th width="13%" class="text-end">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @php $byKomp = $items->groupBy(fn($r) => $r->komponen?->nama ?? '(tanpa komponen)'); @endphp
                @foreach ($byKomp as $namaKomp => $rows)
                    @foreach ($rows as $idx => $r)
                        <tr>
                            @if ($idx === 0)
                                <td rowspan="{{ $rows->count() }}" style="vertical-align: top;"><em>{{ $namaKomp }}</em></td>
                            @endif
                            <td>{{ $r->item }}</td>
                            <td>{{ $r->justifikasi }}</td>
                            <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }}</td>
                            <td>{{ $r->satuan }}</td>
                            <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr><td colspan="6" class="text-end"><strong>SUB TOTAL</strong></td><td class="text-end"><strong>Rp {{ number_format($items->sum('sub_total'), 0, ',', '.') }}</strong></td></tr>
            </tbody>
        </table>
    @endforeach
    <table class="bordered">
        <tr><td class="text-end"><strong>TOTAL ANGGARAN</strong></td><td width="20%" class="text-end"><strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></td></tr>
    </table>
@endif

<div class="signature">
    <p>Batam, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}</p>
    <p>Ketua Pengusul,</p>
    @php $ketuaTtd = $p->ketua->ttd_path ? storage_path('app/public/' . $p->ketua->ttd_path) : null; @endphp
    @if ($ketuaTtd && file_exists($ketuaTtd))
        <img src="{{ $ketuaTtd }}" style="height:70px; margin: 4px 0;">
    @else
        <br><br><br>
    @endif
    <p><strong>{{ $p->ketua->nama_lengkap }}</strong><br>NIDN. {{ $p->ketua->nidn ?? '-' }}</p>
</div>

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
            @php $ketuaTtdL = $p->ketua->ttd_path ? storage_path('app/public/' . $p->ketua->ttd_path) : null; @endphp
            @if ($ketuaTtdL && file_exists($ketuaTtdL))
                <img src="{{ $ketuaTtdL }}" style="height:70px; margin: 4px 0;">
            @else
                <br><br><br><br>
            @endif
            <p><strong><u>{{ $p->ketua->nama_lengkap }}</u></strong><br>NIDN. {{ $p->ketua->nidn ?? '-' }}</p>
        </td>
    </tr>
</table>

</body>
</html>
