<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Proposal — {{ $tahun }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10pt; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px; }
        .header h2 { margin: 0; font-size: 14pt; }
        .header h3 { margin: 4px 0 0; font-size: 11pt; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 5px 8px; }
        th { background: #f1f3f8; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background: #f8f9fa; }
        .meta { font-size: 9.5pt; color: #555; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h2>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
    <h3>UNIVERSITAS BATAM</h3>
    <h3 style="margin-top:6px;">REKAP PROPOSAL HIBAH INTERNAL TAHUN {{ $tahun }}</h3>
</div>

<div class="meta">
    Periode: <strong>{{ $periode?->nama ?? '-' }}</strong>
    @if ($skema) &middot; Skema: <strong>{{ $skema->nama }}</strong> @endif
    &middot; Dicetak: {{ now()->translatedFormat('d F Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th width="40">No</th>
            <th>Fakultas</th>
            <th width="80" class="text-center">Total</th>
            <th width="80" class="text-center">Disetujui</th>
            <th width="80" class="text-center">Revisi</th>
            <th width="80" class="text-center">Ditolak</th>
            <th width="100" class="text-center">% Disetujui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $r['nama'] }}</td>
                <td class="text-center">{{ $r['total'] }}</td>
                <td class="text-center">{{ $r['disetujui'] }}</td>
                <td class="text-center">{{ $r['revisi'] }}</td>
                <td class="text-center">{{ $r['ditolak'] }}</td>
                <td class="text-end">{{ $r['persen_disetujui'] }}%</td>
            </tr>
        @endforeach
        <tr class="total-row">
            <td></td>
            <td>TOTAL</td>
            <td class="text-center">{{ $totals['total'] }}</td>
            <td class="text-center">{{ $totals['disetujui'] }}</td>
            <td class="text-center">{{ $totals['revisi'] }}</td>
            <td class="text-center">{{ $totals['ditolak'] }}</td>
            <td class="text-end">{{ $totals['persen_disetujui'] }}%</td>
        </tr>
    </tbody>
</table>

<p style="margin-top:30px; font-size:9pt;">
    Batam, {{ now()->translatedFormat('d F Y') }}<br>
    LPPM Universitas Batam
</p>

</body>
</html>
