@extends('layouts.reviewer')

@section('title', 'Penilaian Proposal')

@php $activeNav = 'penilaian'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Penilaian Proposal</h4>
            <p class="text-muted small mb-0">{{ ucfirst(str_replace('reviewer_', 'Reviewer ', $penugasan->peran)) }} &middot; Deadline: {{ $penugasan->deadline->format('d M Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('reviewer.proposal.show', $proposal) }}" class="btn btn-sm btn-outline-secondary"><i class="ri-eye-line"></i> Lihat Proposal</a>
            <a href="{{ route('reviewer.proposal.index') }}" class="btn btn-sm btn-light"><i class="ri-arrow-left-line"></i> Kembali</a>
        </div>
    </div>

    {{-- Ringkasan Proposal --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">Judul Proposal</small><br>
                    <strong>{{ $proposal->judul }}</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Ketua Peneliti</small><br>
                    {{ $proposal->ketua->nama_lengkap }}
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Skema / Anggaran</small><br>
                    {{ $proposal->skemaHibah->nama }} &middot; Rp {{ number_format($totalRab, 0, ',', '.') }}
                </div>
            </div>
            @if ($proposal->mitra->isNotEmpty())
                <hr class="my-2">
                <small class="text-muted">Mitra</small>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    @foreach ($proposal->mitra as $m)
                        <span class="badge bg-light text-dark border">
                            {{ $m->nama_mitra }}
                            @if ($m->dokumen_path)
                                <a href="{{ asset('storage/' . $m->dokumen_path) }}" download class="ms-1 text-danger" title="Download PDF Mitra"><i class="ri-download-2-line"></i></a>
                            @endif
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('reviewer.penilaian.submit', $penugasan) }}">
        @csrf

        <div class="row g-3">
            <div class="col-lg-8">
                {{-- Tabel Penilaian --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><h6 class="mb-0">Komponen Penilaian</h6></div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Berikan skor 1-5 untuk setiap komponen. Nilai akhir dihitung otomatis: <code>(skor / 5) × bobot</code>.</p>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Komponen Penilaian</th>
                                        <th width="100" class="text-center">Bobot (%)</th>
                                        <th width="140">Skor (1-5)</th>
                                        <th width="120" class="text-end">Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaList as $k)
                                        @php
                                            $existSkor = $existingDetail[$k->id]?->skor ?? '';
                                            $existCatatan = $existingDetail[$k->id]?->catatan ?? '';
                                        @endphp
                                        <tr class="kriteria-row" data-bobot="{{ $k->bobot_persen }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nama }}@if ($k->deskripsi)<br><small class="text-muted">{{ $k->deskripsi }}</small>@endif</td>
                                            <td class="text-center">{{ $k->bobot_persen }}</td>
                                            <td>
                                                <select name="skor[{{ $k->id }}]" class="form-select form-select-sm skor-input" required>
                                                    <option value="">--</option>
                                                    @foreach ([1, 2, 3, 4, 5] as $s)
                                                        <option value="{{ $s }}" @selected($existSkor == $s)>{{ $s }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-end nilai-cell">
                                                @if ($existSkor)
                                                    {{ number_format(($existSkor / 5) * $k->bobot_persen, 2) }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light fw-bold"><td colspan="4" class="text-end">TOTAL NILAI:</td><td id="totalNilai" class="text-end fs-5 text-primary">{{ number_format($penugasan->penilaian?->nilai_total ?? 0, 2) }}</td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Catatan per Komponen --}}
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Catatan per Komponen <span class="text-muted small">(opsional, maks 500 karakter)</span></h6></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach ($kriteriaList as $k)
                                <li class="nav-item"><button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#c{{ $k->id }}" type="button">{{ $loop->iteration }}. {{ Str::limit($k->nama, 20) }}</button></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($kriteriaList as $k)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="c{{ $k->id }}">
                                    <textarea name="catatan_kriteria[{{ $k->id }}]" rows="3" maxlength="500" class="form-control" placeholder="Catatan untuk komponen {{ $k->nama }}">{{ $existingDetail[$k->id]?->catatan ?? '' }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar: Ringkasan + Rekomendasi --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><h6 class="mb-0">Ringkasan Penilaian</h6></div>
                    <div class="card-body">
                        <p class="text-muted small mb-1">Total Nilai</p>
                        <h2 id="totalNilaiBig" class="text-success mb-0">{{ number_format($penugasan->penilaian?->nilai_total ?? 0, 2) }}<small class="text-muted fs-6"> / 100</small></h2>

                        <hr>
                        <label class="form-label">Rekomendasi <span class="text-danger">*</span></label>
                        <select name="rekomendasi" required class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach (['disetujui' => 'Disetujui (tanpa revisi)', 'revisi_minor' => 'Revisi Minor', 'revisi_mayor' => 'Revisi Mayor', 'ditolak' => 'Ditolak'] as $val => $label)
                                <option value="{{ $val }}" @selected($penugasan->penilaian?->rekomendasi === $val)>{{ $label }}</option>
                            @endforeach
                        </select>

                        <div class="mt-3">
                            <label class="form-label">Catatan untuk Peneliti <span class="text-danger">*</span></label>
                            <textarea name="catatan_umum" rows="6" maxlength="500" required class="form-control">{{ $penugasan->penilaian?->catatan_umum ?? '' }}</textarea>
                            <small class="text-muted">Catatan akan ditampilkan kepada dosen.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3"><i class="ri-save-line me-1"></i> Simpan Penilaian</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
function recalcTotal() {
    let total = 0;
    document.querySelectorAll('.kriteria-row').forEach(row => {
        const skor = parseInt(row.querySelector('.skor-input').value) || 0;
        const bobot = parseFloat(row.dataset.bobot) || 0;
        const nilai = (skor / 5) * bobot;
        row.querySelector('.nilai-cell').textContent = nilai.toFixed(2);
        total += nilai;
    });
    document.getElementById('totalNilai').textContent = total.toFixed(2);
    document.getElementById('totalNilaiBig').innerHTML = total.toFixed(2) + '<small class="text-muted fs-6"> / 100</small>';
}
document.querySelectorAll('.skor-input').forEach(el => el.addEventListener('change', recalcTotal));
</script>
@endsection
