<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Hasil Review — {{ $tahun }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9.5pt; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px; }
        .header h2 { margin: 0; font-size: 13pt; }
        .header h3 { margin: 4px 0 0; font-size: 11pt; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 9pt; }
        th, td { border: 1px solid #444; padding: 4px 6px; vertical-align: top; }
        th { background: #f1f3f8; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .meta { font-size: 9pt; color: #555; margin-bottom: 8px; }
        .summary { margin-top: 15px; }
        .summary td { border: 1px solid #ccc; padding: 6px 10px; }
    </style>
</head>
<body>

<div class="header">
    <h2>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
    <h3>UNIVERSITAS BATAM</h3>
    <h3 style="margin-top:6px;">REKAP HASIL REVIEW PROPOSAL HIBAH TAHUN {{ $tahun }}</h3>
</div>

<div class="meta">
    Periode: <strong>{{ $periode?->nama ?? '-' }}</strong>
    @if ($skema) &middot; Skema: <strong>{{ $skema->nama }}</strong> @endif
    &middot; Dicetak: {{ now()->translatedFormat('d F Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th>Judul Proposal</th>
            <th width="120">Ketua</th>
            <th width="50">Fak</th>
            <th width="100">Skema</th>
            <th width="50" class="text-center">R1</th>
            <th width="50" class="text-center">R2</th>
            <th width="60" class="text-center">Rata-rata</th>
            <th width="80">Kategori</th>
            <th width="80">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $r['judul'] }}</td>
                <td>{{ $r['ketua'] }}</td>
                <td>{{ $r['fakultas'] }}</td>
                <td>{{ $r['skema'] }}</td>
                <td class="text-center">{{ $r['nilai_r1'] ?? '-' }}</td>
                <td class="text-center">{{ $r['nilai_r2'] ?? '-' }}</td>
                <td class="text-center"><strong>{{ $r['rata_rata'] !== null ? number_format($r['rata_rata'], 2) : '-' }}</strong></td>
                <td>{{ $r['kategori'] }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $r['status'])) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="summary">
    <tr>
        <td><strong>Total Proposal</strong></td><td>{{ $stats['total'] }}</td>
        <td><strong>Rata-rata Skor</strong></td><td>{{ number_format($stats['rata_rata'], 2) }}</td>
        <td><strong>Skor Tertinggi</strong></td><td>{{ number_format($stats['tertinggi'], 2) }}</td>
        <td><strong>Skor Terendah</strong></td><td>{{ number_format($stats['terendah'], 2) }}</td>
    </tr>
</table>

<p style="margin-top:30px; font-size:9pt;">
    Batam, {{ now()->translatedFormat('d F Y') }}<br>
    LPPM Universitas Batam
</p>

</body>
</html>
