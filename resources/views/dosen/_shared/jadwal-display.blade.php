{{--
    Render Gantt table jadwal (read-only).
    Variabel: $p (Proposal), $variant ('show' atau 'pdf')
--}}
@php
    $jadwal = $p->jadwal_json ?? [];
    $rows = $jadwal['rows'] ?? [];
    $bulanMulai = $jadwal['bulan_mulai'] ?? null;
    $legacy = $jadwal['text'] ?? null;
    $durasi = max(1, (int) ($p->durasi_bulan ?? 1));

    $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $bulanLabels = [];
    if ($bulanMulai) {
        try {
            $start = \Carbon\Carbon::parse($bulanMulai . '-01');
            for ($i = 0; $i < $durasi; $i++) {
                $d = (clone $start)->addMonths($i);
                $bulanLabels[] = $namaBulan[(int) $d->format('n') - 1] . ' ' . $d->format('Y');
            }
        } catch (\Exception $e) {
            $bulanLabels = array_map(fn($i) => 'Bulan ' . $i, range(1, $durasi));
        }
    } else {
        $bulanLabels = array_map(fn($i) => 'Bulan ' . $i, range(1, $durasi));
    }

    $isPdf = ($variant ?? 'show') === 'pdf';
    $cellColor = $isPdf ? '#0d6efd' : '#0d6efd';
@endphp

@if (! empty($rows))
    <table class="{{ $isPdf ? 'bordered small' : 'table table-bordered table-sm small mb-0' }}" style="{{ $isPdf ? 'width:100%; table-layout:fixed;' : '' }}">
        <thead {!! $isPdf ? '' : 'class="table-light text-center"' !!}>
            <tr>
                <th rowspan="2" style="width:{{ $isPdf ? '5%' : '40px' }};">No</th>
                <th rowspan="2" style="{{ $isPdf ? 'width:30%; word-wrap:break-word;' : 'min-width:220px;' }}">Kegiatan</th>
                <th colspan="{{ $durasi }}" class="text-center">Bulan</th>
            </tr>
            <tr>
                @foreach ($bulanLabels as $lbl)
                    <th class="text-center" style="font-size:{{ $isPdf ? '8pt' : '9pt' }}; word-wrap:break-word;">{{ $lbl }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $i => $r)
                @php
                    $s = max(1, (int) ($r['start'] ?? 1));
                    $e = max($s, (int) ($r['end'] ?? $s));
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td style="{{ $isPdf ? 'word-wrap:break-word; overflow-wrap:break-word;' : '' }}">{{ $r['keterangan'] ?? '-' }}</td>
                    @for ($i2 = 1; $i2 <= $durasi; $i2++)
                        <td style="text-align:center; {{ $i2 >= $s && $i2 <= $e ? 'background:' . $cellColor . ';' : '' }}">&nbsp;</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif (! empty($legacy))
    <p class="small {{ $isPdf ? '' : 'text-muted' }}" style="white-space: pre-wrap;">{{ $legacy }}</p>
@else
    <p class="{{ $isPdf ? 'text-muted small' : 'text-muted small mb-0' }}">Jadwal belum diisi.</p>
@endif
