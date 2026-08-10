{{--
    Section Jadwal — timeline table.
    Variabel yang diharapkan:
      $sectionNo, $sectionLabel
      $jadwalRows   : array of {keterangan,start,end}
      $jadwalBulan  : string YYYY-MM (atau '')
      $jadwalLegacy : string (legacy textarea content, untuk fallback)
      $durasiAwal   : int (durasi bulan awal proposal, untuk fallback)
--}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="ri-calendar-line text-primary me-2"></i>{{ $sectionNo }}. {{ $sectionLabel }}</h6>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addJadwalRow()">
            <i class="ri-add-line"></i> Tambah Kegiatan
        </button>
    </div>
    <div class="card-body">
        @php
            // Pertahankan baris jadwal yang baru diketik bila validasi gagal.
            if (old('jadwal_keterangan') !== null) {
                $jadwalRows = collect(array_keys((array) old('jadwal_keterangan')))->map(fn ($i) => [
                    'keterangan' => old("jadwal_keterangan.{$i}"),
                    'start'      => old("jadwal_start.{$i}") ?: 1,
                    'end'        => old("jadwal_end.{$i}") ?: 1,
                ])->all();
            }

            // `<input type="month">` tidak didukung Firefox & Safari — di sana field itu
            // jatuh jadi input teks biasa, dosen mengetik bebas ("Juli 2026"), lalu ditolak
            // aturan date_format:Y-m sehingga seluruh form gagal disimpan. Dua select di
            // bawah + hidden input menghasilkan format YYYY-MM yang sama di semua browser.
            $bulanMulaiVal = old('jadwal_bulan_mulai', $jadwalBulan);
            $bmTahun = $bmBulan = null;
            if ($bulanMulaiVal && preg_match('/^(\d{4})-(\d{2})$/', $bulanMulaiVal, $m)) {
                [$bmTahun, $bmBulan] = [(int) $m[1], $m[2]];
            }
            $namaBulanId = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
            ];
            // Rentang tahun selalu mencakup nilai tersimpan, supaya proposal lama tetap tampil.
            $tahunMin = min((int) date('Y') - 1, $bmTahun ?: PHP_INT_MAX);
            $tahunMax = max((int) date('Y') + 5, $bmTahun ?: 0);
        @endphp

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Bulan Mulai Pelaksanaan <span class="text-danger">*</span></label>
                <div class="row g-2">
                    <div class="col-7">
                        <select id="jadwalBulanMulaiBulan" class="form-select" onchange="syncBulanMulai()">
                            <option value="">-- Bulan --</option>
                            @foreach ($namaBulanId as $val => $nama)
                                <option value="{{ $val }}" @selected($bmBulan === $val)>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <select id="jadwalBulanMulaiTahun" class="form-select" onchange="syncBulanMulai()">
                            <option value="">-- Tahun --</option>
                            @for ($y = $tahunMin; $y <= $tahunMax; $y++)
                                <option value="{{ $y }}" @selected($bmTahun === $y)>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <input type="hidden" name="jadwal_bulan_mulai" id="jadwalBulanMulai" value="{{ $bulanMulaiVal }}">
                <small class="text-muted">Akan jadi "Bulan 1" di kolom tabel.</small>
            </div>
            <div class="col-md-8 align-self-end small text-muted">
                Durasi otomatis ikut field <strong>Durasi (bln)</strong> di Section 2.
                Sel berwarna = bulan kegiatan berjalan.
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle mb-0" id="jadwalTable" style="min-width:900px;">
                <thead class="table-light text-center">
                    <tr>
                        <th rowspan="2" style="width:50px;">No</th>
                        <th rowspan="2" style="min-width:240px;">Kegiatan / Keterangan</th>
                        <th rowspan="2" style="width:110px;">Start</th>
                        <th rowspan="2" style="width:110px;">End</th>
                        <th id="jadwalBulanHead">Bulan</th>
                    </tr>
                    <tr id="jadwalBulanRow">
                        {{-- diisi JS --}}
                    </tr>
                </thead>
                <tbody id="jadwalBody">
                    @forelse ($jadwalRows as $i => $r)
                        <tr class="jadwal-row">
                            <td class="text-center jadwal-no">{{ $i + 1 }}</td>
                            <td><input type="text" name="jadwal_keterangan[]" class="form-control form-control-sm" value="{{ $r['keterangan'] ?? '' }}" placeholder="Mis. Sosialisasi awal, Penyusunan instrumen"></td>
                            <td><select name="jadwal_start[]" class="form-select form-select-sm jadwal-start" onchange="renderJadwalGantt()" data-val="{{ $r['start'] ?? 1 }}"></select></td>
                            <td><select name="jadwal_end[]" class="form-select form-select-sm jadwal-end" onchange="renderJadwalGantt()" data-val="{{ $r['end'] ?? 1 }}"></select></td>
                            {{-- preview cells akan di-append oleh JS sebagai <td class="jadwal-cell"> --}}
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Fallback legacy: tampilkan jadwal lama agar tidak hilang saat migrasi format --}}
        @if (! empty($jadwalLegacy) && empty($jadwalRows))
            <div class="alert alert-warning small mt-3 mb-0">
                <div class="fw-semibold mb-1"><i class="ri-information-line"></i> Format jadwal lama (teks bebas) — silakan isi ulang ke tabel di atas:</div>
                <div style="white-space: pre-wrap;">{{ $jadwalLegacy }}</div>
            </div>
        @endif
    </div>
</div>

<template id="jadwalRowTpl">
    <tr class="jadwal-row">
        <td class="text-center jadwal-no"></td>
        <td><input type="text" name="jadwal_keterangan[]" class="form-control form-control-sm" placeholder="Kegiatan"></td>
        <td><select name="jadwal_start[]" class="form-select form-select-sm jadwal-start" onchange="renderJadwalGantt()"></select></td>
        <td><select name="jadwal_end[]" class="form-select form-select-sm jadwal-end" onchange="renderJadwalGantt()"></select></td>
    </tr>
</template>

<script>
const NAMA_BULAN_ID = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

function getDurasiBulan() {
    const el = document.querySelector('input[name="durasi_bulan"]');
    return Math.max(1, parseInt(el?.value || 1));
}

// Gabungkan dua select menjadi satu nilai YYYY-MM di hidden input yang dikirim ke server.
function syncBulanMulai() {
    const bulan = document.getElementById('jadwalBulanMulaiBulan')?.value || '';
    const tahun = document.getElementById('jadwalBulanMulaiTahun')?.value || '';
    const hidden = document.getElementById('jadwalBulanMulai');
    if (hidden) hidden.value = (bulan && tahun) ? (tahun + '-' + bulan) : '';
    renderJadwalGantt();
}

function bulanLabel(idx /* 1-based */) {
    const mulai = document.getElementById('jadwalBulanMulai')?.value; // YYYY-MM
    if (!mulai) return 'Bulan ' + idx;
    const [y, m] = mulai.split('-').map(Number);
    const d = new Date(y, m - 1 + (idx - 1), 1);
    return NAMA_BULAN_ID[d.getMonth()] + ' ' + d.getFullYear();
}

function rebuildBulanColumns() {
    const durasi = getDurasiBulan();
    // header row 2
    const headRow = document.getElementById('jadwalBulanRow');
    headRow.innerHTML = '';
    for (let i = 1; i <= durasi; i++) {
        const th = document.createElement('th');
        th.style.minWidth = '60px';
        th.className = 'small text-center';
        th.textContent = bulanLabel(i);
        headRow.appendChild(th);
    }
    // header row 1 colspan
    document.getElementById('jadwalBulanHead').setAttribute('colspan', durasi);

    // rebuild start/end dropdowns
    document.querySelectorAll('.jadwal-start, .jadwal-end').forEach(sel => {
        // Pilihan user adalah sumber kebenaran. `data-val` hanya seed dari server
        // untuk build pertama (saat select masih kosong) dan dikonsumsi sekali saja:
        // selama data-val masih dibaca, setiap onchange menimpa balik pilihan user
        // ke nilai tersimpan sehingga bulan tampak "tidak bisa diubah".
        const cur = sel.value || sel.dataset.val;
        delete sel.dataset.val;
        sel.innerHTML = '';
        for (let i = 1; i <= durasi; i++) {
            const opt = document.createElement('option');
            opt.value = i;
            opt.textContent = 'Bulan ' + i;
            sel.appendChild(opt);
        }
        if (cur) sel.value = Math.min(parseInt(cur), durasi);
    });

    // rebuild preview cells
    document.querySelectorAll('#jadwalBody .jadwal-row').forEach(row => {
        // hapus cell preview lama
        row.querySelectorAll('.jadwal-cell').forEach(c => c.remove());
        const start = parseInt(row.querySelector('.jadwal-start').value || 0);
        const end = parseInt(row.querySelector('.jadwal-end').value || 0);
        for (let i = 1; i <= durasi; i++) {
            const td = document.createElement('td');
            td.className = 'jadwal-cell text-center small';
            td.style.minWidth = '60px';
            if (i >= start && i <= end && start && end) {
                td.style.background = '#0d6efd';
                td.innerHTML = '&nbsp;';
            }
            row.appendChild(td);
        }
    });
}

function renderJadwalGantt() {
    rebuildBulanColumns();
    // renumber rows
    document.querySelectorAll('#jadwalBody .jadwal-row').forEach((row, i) => {
        const no = row.querySelector('.jadwal-no');
        if (no) no.textContent = i + 1;
    });
}

function addJadwalRow() {
    const tpl = document.getElementById('jadwalRowTpl').content.cloneNode(true);
    document.getElementById('jadwalBody').appendChild(tpl);
    renderJadwalGantt();
}

// react ke perubahan durasi_bulan
document.addEventListener('DOMContentLoaded', () => {
    const dur = document.querySelector('input[name="durasi_bulan"]');
    if (dur) dur.addEventListener('input', renderJadwalGantt);
    renderJadwalGantt();
});
</script>
