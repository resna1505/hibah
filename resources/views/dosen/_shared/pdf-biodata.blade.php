<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Biodata Pengusul — {{ $p->judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11pt; color: #222; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px; }
        .header h2 { margin: 0; font-size: 14pt; }
        .header h3 { margin: 4px 0 0; font-size: 12pt; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 10pt; }
        table.bordered td, table.bordered th { border: 1px solid #444; padding: 5px 7px; vertical-align: top; }
        table.bordered th { background: #f1f3f8; }
        h4 { font-size: 11pt; margin: 14px 0 6px; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
        h5 { font-size: 10pt; margin: 10px 0 4px; color: #444; }
        .small { font-size: 9.5pt; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .text-muted { color: #777; }
        .biodata-block { margin-bottom: 20px; }
        .foto-box { width: 90px; text-align: center; vertical-align: top; }
        .biodata-block p { margin: 2px 0; }
    </style>
</head>
<body>

@php
    $kopPath = \App\Models\Master\Pengaturan::get('lppm_kop_path');
    $kopFile = $kopPath ? storage_path('app/public/' . $kopPath) : null;

    $jenisLabel = $p->skemaHibah?->jenis === 'pkm' ? 'PKM' : 'Penelitian';

    $tim = collect([['dosen' => $p->ketua, 'peran' => 'Ketua Pengusul']]);
    foreach ($p->anggota->where('peran', 'anggota_dosen') as $a) {
        if ($a->dosen) $tim->push(['dosen' => $a->dosen, 'peran' => 'Anggota Pengusul']);
    }
@endphp

<div class="header">
    @if ($kopFile && file_exists($kopFile))
        <img src="{{ $kopFile }}" style="max-width: 100%; max-height: 90px; margin-bottom: 4px;">
    @else
        <h2>LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
        <h3>UNIVERSITAS BATAM</h3>
    @endif
    <h3 style="margin-top:6px;">BIODATA KETUA DAN ANGGOTA TIM PENGUSUL</h3>
    <h3 style="font-size:10pt; margin-top:2px;">Proposal {{ $jenisLabel }}: {{ $p->judul }}</h3>
</div>

@foreach ($tim as $i => $item)
    @php $d = $item['dosen']; @endphp
    <div class="biodata-block">
        <h4>Biodata {{ $loop->iteration }}. {{ $item['peran'] }}</h4>

        <table class="bordered">
            <tr>
                @php $fotoFile = $d->foto_path ? storage_path('app/public/' . $d->foto_path) : null; @endphp
                <td rowspan="6" class="foto-box">
                    @if ($fotoFile && file_exists($fotoFile))
                        <img src="{{ $fotoFile }}" style="max-width: 80px; max-height: 100px;" class="border">
                    @else
                        <div style="width:80px;height:100px;border:1px dashed #888;display:inline-block;line-height:100px;">Foto</div>
                    @endif
                </td>
                <td width="22%"><small>Nama Lengkap</small></td>
                <td><strong>{{ $d->nama_lengkap }}</strong></td>
            </tr>
            <tr><td><small>NIDN / NIDK</small></td><td>{{ $d->nidn ?? '-' }}{{ $d->nidk ? ' / ' . $d->nidk : '' }}</td></tr>
            <tr><td><small>Jabatan Fungsional</small></td><td>{{ $d->jabatan_fungsional ?? '-' }}</td></tr>
            <tr><td><small>Pendidikan Terakhir</small></td><td>{{ $d->pendidikan_terakhir ?? '-' }}</td></tr>
            <tr><td><small>Program Studi / Fakultas</small></td><td>{{ $d->prodi?->nama ?? '-' }} / {{ $d->fakultas?->nama ?? '-' }}</td></tr>
            <tr><td><small>ID Sinta / Scopus</small></td><td>{{ $d->sinta_id ?? '-' }} / {{ $d->scopus_id ?? '-' }}</td></tr>
            <tr>
                <td colspan="2"><small>Email / No. HP</small></td>
                <td>{{ $d->user?->email ?? '-' }} / {{ $d->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><small>Bidang Keahlian</small></td>
                <td>{{ $d->keahlian->pluck('nama')->join(', ') ?: '-' }}</td>
            </tr>
        </table>

        @php
            $rwPenelitian = \App\Models\Transaction\RiwayatPenelitian::where('dosen_id', $d->id)->orderByDesc('tahun')->limit(10)->get();
            $rwPkm = \App\Models\Transaction\RiwayatPkm::where('dosen_id', $d->id)->orderByDesc('tahun')->limit(10)->get();
            $rwHki = \App\Models\Transaction\RiwayatHki::where('dosen_id', $d->id)->orderByDesc('tahun_pengajuan')->limit(10)->get();
        @endphp

        @if ($rwPenelitian->isNotEmpty())
            <h5>Riwayat Penelitian (10 terakhir)</h5>
            <table class="bordered small">
                <thead><tr><th width="6%">#</th><th width="8%">Tahun</th><th>Judul</th><th width="18%">Pendanaan</th><th width="12%">Peran</th><th width="10%">Status</th></tr></thead>
                <tbody>
                    @foreach ($rwPenelitian as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->tahun }}</td>
                            <td>{{ $r->judul }}</td>
                            <td>{{ $r->sumber_pendanaan ?? '-' }}</td>
                            <td>{{ $r->peran ?? '-' }}</td>
                            <td>{{ $r->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($rwPkm->isNotEmpty())
            <h5>Riwayat Pengabdian (10 terakhir)</h5>
            <table class="bordered small">
                <thead><tr><th width="6%">#</th><th width="8%">Tahun</th><th>Judul</th><th width="18%">Mitra / Lokasi</th><th width="12%">Peran</th><th width="10%">Status</th></tr></thead>
                <tbody>
                    @foreach ($rwPkm as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->tahun }}</td>
                            <td>{{ $r->judul }}</td>
                            <td>{{ trim(($r->mitra ?? '') . ($r->lokasi ? ' / ' . $r->lokasi : ''), ' /') ?: '-' }}</td>
                            <td>{{ $r->peran ?? '-' }}</td>
                            <td>{{ $r->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($rwHki->isNotEmpty())
            <h5>Riwayat HKI</h5>
            <table class="bordered small">
                <thead><tr><th width="6%">#</th><th width="12%">Jenis</th><th>Judul</th><th width="14%">No. Sertifikat</th><th width="10%">Tahun</th><th width="12%">Status</th></tr></thead>
                <tbody>
                    @foreach ($rwHki as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->jenis_hki }}</td>
                            <td>{{ $r->judul }}</td>
                            <td>{{ $r->no_sertifikat ?? $r->no_pendaftaran ?? '-' }}</td>
                            <td>{{ $r->tahun_terbit ?? $r->tahun_pengajuan }}</td>
                            <td>{{ $r->status_hki ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($rwPenelitian->isEmpty() && $rwPkm->isEmpty() && $rwHki->isEmpty())
            <p class="text-muted small"><em>Belum ada riwayat penelitian / PKM / HKI yang diisi.</em></p>
        @endif

        <div style="margin-top:14px;">
            <table>
                <tr>
                    <td width="60%"></td>
                    <td width="40%" style="text-align: center;">
                        <p>{{ \App\Models\Master\Pengaturan::get('institusi_kota', 'Batam') }}, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}</p>
                        @php $ttdFile = $d->ttd_path ? storage_path('app/public/' . $d->ttd_path) : null; @endphp
                        @if ($ttdFile && file_exists($ttdFile))
                            <img src="{{ $ttdFile }}" style="height:60px; margin: 4px 0;">
                        @else
                            <br><br><br>
                        @endif
                        <p><strong><u>{{ $d->nama_lengkap }}</u></strong><br>NIDN. {{ $d->nidn ?? '-' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if (! $loop->last)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach

</body>
</html>
