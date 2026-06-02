<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Pernyataan — {{ $p->judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11pt; color: #222; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 14px; }
        .header h2 { margin: 0; font-size: 14pt; }
        .header h3 { margin: 4px 0 0; font-size: 12pt; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; }
        table.identitas td { padding: 3px 4px; vertical-align: top; }
        h4 { font-size: 12pt; text-align: center; text-decoration: underline; margin: 14px 0 10px; }
        p { margin: 6px 0; text-align: justify; }
        .signature { margin-top: 26px; }
        .small { font-size: 9.5pt; }
    </style>
</head>
<body>

@php
    use App\Models\Master\Pengaturan;
    $institusi = Pengaturan::get('institusi_nama', 'Universitas Batam');
    $kota = Pengaturan::get('institusi_kota', 'Batam');
    $lppmNama = Pengaturan::get('lppm_ketua_nama', 'Ketua LPPM');
    $lppmJabatan = Pengaturan::get('lppm_ketua_jabatan', 'Ketua LPPM');
    $ttdFile = $p->ketua->ttd_path ? storage_path('app/public/' . $p->ketua->ttd_path) : null;
    $jenisLabel = $p->skemaHibah?->jenis === 'pkm' ? 'Pengabdian kepada Masyarakat' : 'Penelitian';
@endphp

<div class="header">
    @include('dosen._shared.pdf-kop')
</div>

<h4>SURAT PERNYATAAN KETUA PENGUSUL</h4>

<p>Yang bertanda tangan di bawah ini:</p>

<table class="identitas" style="margin-left: 24px;">
    <tr><td width="30%">Nama Lengkap</td><td width="3%">:</td><td>{{ $p->ketua->nama_lengkap }}</td></tr>
    <tr><td>NIDN</td><td>:</td><td>{{ $p->ketua->nidn ?? '-' }}</td></tr>
    <tr><td>Pangkat / Golongan</td><td>:</td><td>{{ $p->ketua->pangkat_golongan ?? '-' }}</td></tr>
    <tr><td>Jabatan Fungsional</td><td>:</td><td>{{ $p->ketua->jabatan_fungsional ?? '-' }}</td></tr>
    <tr><td>Program Studi / Fakultas</td><td>:</td><td>{{ $p->ketua->prodi?->nama ?? '-' }} / {{ $p->ketua->fakultas?->nama ?? '-' }}</td></tr>
</table>

<p style="margin-top:12px;">Dengan ini menyatakan bahwa proposal {{ $jenisLabel }} saya dengan judul:</p>

<p style="margin-left: 24px; font-style: italic;"><strong>"{{ $p->judul }}"</strong></p>

<p>
    yang diusulkan dalam <strong>{{ $p->skemaHibah?->nama }}</strong> tahun anggaran
    {{ $p->periodeHibah?->tahun ?? now()->year }}
    pada {{ $institusi }} bersifat <strong>original</strong> dan
    <strong>belum pernah didanai</strong> oleh lembaga / sumber dana lain.
</p>

<p>
    Apabila di kemudian hari ditemukan ketidaksesuaian dengan pernyataan ini,
    maka saya bersedia dituntut dan diproses sesuai dengan ketentuan yang berlaku
    dan <strong>mengembalikan seluruh biaya</strong> yang sudah diterima ke kas negara
    /kas {{ $institusi }}.
</p>

<p>
    Demikian pernyataan ini dibuat dengan sesungguhnya dan dengan sebenar-benarnya
    untuk dipergunakan sebagaimana mestinya.
</p>

<div class="signature">
    <table>
        <tr>
            <td width="55%"></td>
            <td width="45%" style="text-align: center;">
                <p>{{ $kota }}, {{ ($p->tgl_submit ?? now())->translatedFormat('d F Y') }}</p>
                <p>Yang Menyatakan,</p>
                @if ($ttdFile && file_exists($ttdFile))
                    <div style="margin: 6px 0;">
                        <img src="{{ $ttdFile }}" style="height:70px;">
                    </div>
                @else
                    <br><br><br><br>
                @endif
                <p style="margin-top:2px;">
                    Materai Rp 10.000<br>
                    <strong><u>{{ $p->ketua->nama_lengkap }}</u></strong><br>
                    NIDN. {{ $p->ketua->nidn ?? '-' }}
                </p>
            </td>
        </tr>
    </table>
</div>

<p class="small text-muted" style="margin-top: 30px;"><em>Catatan: Lembar ini wajib ditempel materai Rp 10.000 dan ditandatangani basah sebelum diserahkan ke LPPM.</em></p>

</body>
</html>
