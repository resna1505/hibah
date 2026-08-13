{{--
    PDF proposal versi REVIEWER (blind review).

    Sengaja TIDAK memuat: identitas pengusul (nama, NIDN, prodi, fakultas, Sinta ID),
    daftar anggota, pimpinan mitra, tanda tangan, lembar pengesahan, dan biodata.
    Proposal hanya dikenali lewat nomor registrasinya.

    Dipakai bersama untuk Penelitian & PKM — bedanya hanya pada label dan
    section "Permasalahan & Solusi" yang khusus PKM.

    Variabel: $p (Proposal), $totalRab (int), $isPkm (bool)
--}}
@php
    $jenisLabel = $isPkm ? 'PKM' : 'PENELITIAN';
    $no = 0; // penomoran section mengikuti section yang benar-benar tampil
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Proposal {{ $jenisLabel }} — {{ $p->no_registrasi ?? 'Tanpa Nomor' }}</title>
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
        .notice { border: 1px solid #999; background: #f5f5f5; padding: 6px 9px; font-size: 9pt; margin-bottom: 12px; }
    </style>
</head>
<body>

<div class="header">
    @include('dosen._shared.pdf-kop')
    <h3 style="margin-top:6px;">PROPOSAL {{ $jenisLabel }} — NASKAH PENILAIAN</h3>
    <p style="margin: 4px 0; font-size: 10pt;">
        Kode Proposal: <strong>{{ $p->no_registrasi ?? '-' }}</strong>
    </p>
</div>

<div class="notice">
    <strong>Penilaian tanpa identitas (blind review).</strong>
    Identitas pengusul — nama, NIDN, program studi, dan fakultas — sengaja tidak dicantumkan
    agar penilaian dilakukan murni atas substansi proposal.
</div>

{{-- Judul & ringkas kegiatan (tanpa prodi/fakultas) --}}
<h4>{{ ++$no }}. Judul {{ $isPkm ? 'PKM' : 'Penelitian' }}</h4>
<table class="bordered">
    <tr><td colspan="3"><strong>{{ $p->judul }}</strong></td></tr>
    <tr>
        <td width="33%"><small>Skema Hibah</small><br>{{ $p->skemaHibah->nama }}</td>
        <td width="33%"><small>Total Usulan Dana</small><br>Rp {{ number_format($totalRab, 0, ',', '.') }}</td>
        <td width="34%"><small>Lama Kegiatan</small><br>{{ $p->durasi_bulan }} bulan</td>
    </tr>
</table>

{{-- Komposisi tim: jumlah saja, tanpa nama, agar kecukupan tim tetap dapat dinilai --}}
@php
    $jmlDosen = $p->anggota->where('peran', 'anggota_dosen')->count();
    $jmlMhs   = $p->anggota->where('peran', '!=', 'anggota_dosen')->count();
@endphp
<h4>{{ ++$no }}. Komposisi Tim Pengusul</h4>
<table class="bordered">
    <tr>
        <td width="33%"><small>Ketua</small><br>1 orang</td>
        <td width="33%"><small>Anggota Dosen</small><br>{{ $jmlDosen }} orang</td>
        <td width="34%"><small>Anggota Mahasiswa</small><br>{{ $jmlMhs }} orang</td>
    </tr>
</table>

{{-- Mitra: nama lembaga & permasalahan tetap ditampilkan karena menjadi objek penilaian
     (khususnya PKM), tetapi nama pimpinan mitra disembunyikan. --}}
@if ($p->mitra->isNotEmpty())
    <h4>{{ ++$no }}. Mitra {{ $isPkm ? 'Kerjasama' : $jenisLabel }}</h4>
    <table class="bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Mitra</th>
                <th width="30%">Alamat</th>
                <th>Permasalahan / Kontribusi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($p->mitra as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->nama_mitra }}</td>
                    <td>{{ $m->alamat_mitra ?? '-' }}</td>
                    <td>{{ $m->permasalahan_mitra ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if ($p->bidangStrategis)
    <h4>{{ ++$no }}. Bidang Strategis</h4>
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
    <h4>{{ ++$no }}. Ringkasan</h4>
    <p>{{ $p->ringkasan }}</p>
    @if ($p->kata_kunci)
        <p><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>
    @endif
@endif

@if ($p->pendahuluan)
    <h4>{{ ++$no }}. Pendahuluan</h4>
    <p style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p>
@endif

@if ($isPkm && $p->permasalahan_solusi)
    <h4>{{ ++$no }}. Permasalahan &amp; Solusi</h4>
    <p style="white-space: pre-wrap;">{{ $p->permasalahan_solusi }}</p>
@endif

@if ($p->metode)
    <h4>{{ ++$no }}. Metode {{ $isPkm ? 'Pelaksanaan' : '' }}</h4>
    <p style="white-space: pre-wrap;">{{ $p->metode }}</p>
    @if ($p->metode_diagram_path && file_exists(storage_path('app/public/' . $p->metode_diagram_path)))
        <p class="text-center">
            <img src="{{ storage_path('app/public/' . $p->metode_diagram_path) }}" style="max-width:80%; max-height:300px;">
            <br><small class="text-muted">Diagram Alir {{ $isPkm ? 'Kegiatan' : 'Penelitian' }}</small>
        </p>
    @endif
@endif

@if ($p->rencanaLuaran->isNotEmpty())
    <h4>{{ ++$no }}. Rencana Luaran</h4>
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
    <h4>{{ ++$no }}. Jadwal {{ $isPkm ? 'Pelaksanaan' : 'Penelitian' }}</h4>
    @include('dosen._shared.jadwal-display', ['p' => $p, 'variant' => 'pdf'])
@endif

@if ($p->daftar_pustaka)
    <h4>{{ ++$no }}. Daftar Pustaka</h4>
    <p style="white-space: pre-wrap;" class="small">{{ $p->daftar_pustaka }}</p>
@endif

@if ($p->rab->isNotEmpty())
    <h4>{{ ++$no }}. Rencana Anggaran Biaya (RAB)</h4>
    @php $rabByKategori = $p->rab->groupBy(fn($r) => $r->kategori?->nama ?? '-'); @endphp
    @foreach ($rabByKategori as $namaKategori => $items)
        <p style="margin-top:8px;"><strong>{{ $loop->iteration }}. {{ $namaKategori }}</strong></p>
        <table class="bordered small">
            <thead>
                <tr>
                    <th width="20%">Komponen</th>
                    <th>Item</th>
                    <th width="22%">Justifikasi</th>
                    <th width="8%" class="text-end">Qty</th>
                    <th width="7%">Satuan</th>
                    <th width="13%" class="text-end">Harga Satuan</th>
                    <th width="13%" class="text-end">Sub Total</th>
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
                <tr>
                    <td colspan="6" class="text-end"><strong>SUB TOTAL</strong></td>
                    <td class="text-end"><strong>Rp {{ number_format($items->sum('sub_total'), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    @endforeach
    <table class="bordered">
        <tr>
            <td class="text-end"><strong>TOTAL ANGGARAN</strong></td>
            <td width="20%" class="text-end"><strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
@endif

</body>
</html>
