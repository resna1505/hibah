{{-- Kop surat 2 logo: kiri (UNIBA) + kanan (LPPM). Fallback ke teks jika belum di-upload. --}}
@php
    use App\Models\Master\Pengaturan;
    $kopKiriPath  = Pengaturan::get('kop_kiri_path');
    $kopKananPath = Pengaturan::get('kop_kanan_path');
    $kopKiriFile  = $kopKiriPath  ? storage_path('app/public/' . $kopKiriPath)  : null;
    $kopKananFile = $kopKananPath ? storage_path('app/public/' . $kopKananPath) : null;
    $hasKiri  = $kopKiriFile  && file_exists($kopKiriFile);
    $hasKanan = $kopKananFile && file_exists($kopKananFile);
    $institusi = Pengaturan::get('institusi_nama', 'Universitas Batam');
@endphp

@if ($hasKiri || $hasKanan)
    <table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
        <tr>
            <td style="width:33%; text-align:left; vertical-align:middle;">
                @if ($hasKiri)<img src="{{ $kopKiriFile }}" style="max-height:80px; max-width:100%;">@endif
            </td>
            <td style="width:34%; text-align:center; vertical-align:middle;">
                <div style="font-size: 10pt; font-weight: bold;">LEMBAGA PENELITIAN DAN<br>PENGABDIAN KEPADA MASYARAKAT</div>
                <div style="font-size: 10pt;">{{ strtoupper($institusi) }}</div>
            </td>
            <td style="width:33%; text-align:right; vertical-align:middle;">
                @if ($hasKanan)<img src="{{ $kopKananFile }}" style="max-height:80px; max-width:100%;">@endif
            </td>
        </tr>
    </table>
@else
    <h2 style="margin: 0; font-size: 14pt;">LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</h2>
    <h3 style="margin: 4px 0 0; font-size: 12pt; font-weight: normal;">{{ strtoupper($institusi) }}</h3>
@endif
