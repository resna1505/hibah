<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Substansi Proposal Penelitian — {{ $p->judul }}</title>
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
    <h2>SUBSTANSI PROPOSAL PENELITIAN</h2>
    <h3>{{ $p->judul }}</h3>
    <h3 style="font-size:10pt; margin-top:4px;">{{ $p->skemaHibah->nama }} &middot; Ketua: {{ $p->ketua->nama_lengkap }}</h3>
</div>

@if ($p->pendahuluan)
    <h4>A. Pendahuluan</h4>
    <p style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p>
@endif

@if ($p->metode)
    <h4>B. Metode</h4>
    <p style="white-space: pre-wrap;">{{ $p->metode }}</p>
    @if ($p->metode_diagram_path && file_exists(storage_path('app/public/' . $p->metode_diagram_path)))
        <p class="text-center">
            <img src="{{ storage_path('app/public/' . $p->metode_diagram_path) }}" style="max-width:80%; max-height:300px;">
            <br><small class="text-muted">Diagram Alir Penelitian</small>
        </p>
    @endif
@endif

@if ($p->jadwal_json && ! empty($p->jadwal_json['text']))
    <h4>C. Jadwal Penelitian</h4>
    <p style="white-space: pre-wrap;">{{ $p->jadwal_json['text'] }}</p>
@endif

@if ($p->daftar_pustaka)
    <h4>D. Daftar Pustaka</h4>
    <p style="white-space: pre-wrap;" class="small">{{ $p->daftar_pustaka }}</p>
@endif

@if ($p->rab->isNotEmpty())
    <h4>E. Rencana Anggaran Biaya (RAB)</h4>
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

<div class="signature">
    <p>Batam, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}</p>
    <p>Ketua Pengusul,</p>
    @php $ketuaTtd = $p->ketua->ttd_path ? storage_path('app/public/' . $p->ketua->ttd_path) : null; @endphp
    @if ($ketuaTtd && file_exists($ketuaTtd))
        <img src="{{ $ketuaTtd }}" style="height:70px; margin: 4px 0;">
    @else
        <br><br><br>
    @endif
    <p><strong>{{ $p->ketua->nama_lengkap }}</strong><br>
    NIDN. {{ $p->ketua->nidn ?? '-' }}</p>
</div>

</body>
</html>
