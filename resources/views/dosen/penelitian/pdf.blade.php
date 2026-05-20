<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Proposal Penelitian — {{ $p->judul }}</title>
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
    <h2>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
    <h3>UNIVERSITAS BATAM</h3>
    <h3 style="margin-top:6px;">PROPOSAL PENELITIAN</h3>
</div>

{{-- Section 1: Identitas Proposal --}}
<h4>1. Judul Penelitian</h4>
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

{{-- Section 2: Identitas Pengusul --}}
<h4>2. Identitas Pengusul</h4>
<table class="bordered">
    <thead>
        <tr>
            <th width="30%">Nama, Peran</th>
            <th width="10%">Jenis</th>
            <th width="20%">Program Studi/Bagian</th>
            <th width="25%">Bidang Tugas</th>
            <th width="15%">ID Sinta</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>{{ $p->ketua->nama_lengkap }}</strong><br><small>{{ $p->ketua->nidn ?? '' }}</small><br><em>Ketua Pengusul</em></td>
            <td>Dosen</td>
            <td>{{ $p->ketua->prodi?->nama }}</td>
            <td>Membuat perencanaan penelitian, menyusun proposal, dan mengarahkan pelaksanaan penelitian.</td>
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

{{-- Section 3: Ringkasan --}}
@if ($p->ringkasan)
    <h4>3. Ringkasan</h4>
    <p>{{ $p->ringkasan }}</p>
    @if ($p->kata_kunci)
        <p><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>
    @endif
@endif

{{-- Section 4: Pendahuluan --}}
@if ($p->pendahuluan)
    <h4>4. Pendahuluan</h4>
    <p style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p>
@endif

{{-- Section 5: Metode --}}
@if ($p->metode)
    <h4>5. Metode</h4>
    <p style="white-space: pre-wrap;">{{ $p->metode }}</p>
    @if ($p->metode_diagram_path && file_exists(storage_path('app/public/' . $p->metode_diagram_path)))
        <p class="text-center">
            <img src="{{ storage_path('app/public/' . $p->metode_diagram_path) }}" style="max-width:80%; max-height:300px;">
            <br><small class="text-muted">Diagram Alir Penelitian</small>
        </p>
    @endif
@endif

{{-- Section 6: Hasil yang Diharapkan --}}
@if ($p->hasil_diharapkan_json)
    <h4>6. Hasil yang Diharapkan</h4>
    <table class="bordered">
        <thead><tr><th width="5%">No</th><th>Jenis Luaran</th><th width="30%">Target</th></tr></thead>
        <tbody>
            @foreach ($p->hasil_diharapkan_json as $i => $h)
                <tr><td>{{ $i + 1 }}</td><td>{{ $h['jenis'] ?? '' }}</td><td>{{ $h['target'] ?? '' }}</td></tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- Section 7: Jadwal --}}
@if ($p->jadwal_json && ! empty($p->jadwal_json['text']))
    <h4>7. Jadwal Penelitian</h4>
    <p style="white-space: pre-wrap;">{{ $p->jadwal_json['text'] }}</p>
@endif

{{-- Section 8: Daftar Pustaka --}}
@if ($p->daftar_pustaka)
    <h4>8. Daftar Pustaka</h4>
    <p style="white-space: pre-wrap;" class="small">{{ $p->daftar_pustaka }}</p>
@endif

{{-- Section 9: RAB --}}
@if ($p->rab->isNotEmpty())
    <h4>9. Rencana Anggaran Biaya (RAB)</h4>
    @php $rabByKategori = $p->rab->groupBy('kategori.nama'); @endphp
    @foreach ($rabByKategori as $namaKategori => $items)
        <p style="margin-top:8px;"><strong>{{ $loop->iteration }}. {{ $namaKategori }}</strong></p>
        <table class="bordered small">
            <thead>
                <tr>
                    <th>Item</th>
                    <th width="30%">Justifikasi</th>
                    <th width="10%" class="text-end">Kuantitas</th>
                    <th width="8%">Satuan</th>
                    <th width="15%" class="text-end">Harga Satuan</th>
                    <th width="15%" class="text-end">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $r)
                    <tr>
                        <td>{{ $r->item }}</td>
                        <td>{{ $r->justifikasi }}</td>
                        <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }}</td>
                        <td>{{ $r->satuan }}</td>
                        <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-end"><strong>SUB TOTAL</strong></td>
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

<div class="signature">
    <p>Batam, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}</p>
    <p>Ketua Pengusul,</p>
    <br><br><br>
    <p><strong>{{ $p->ketua->nama_lengkap }}</strong><br>
    NIDN. {{ $p->ketua->nidn ?? '-' }}</p>
</div>

</body>
</html>
