@extends('layouts.operator')

@section('title', 'Detail Penilaian Proposal')

@php
    $activeNav = 'penilaian';

    $rekomendasiBadge = [
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
    ];

    $bisaFinalize = in_array($p->status, ['direview', 'revisi_minor', 'revisi_mayor']);
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detail Penilaian</h4>
            <p class="text-muted small mb-0">{{ $p->judul }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('operator.penilaian.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
            <a href="{{ route('operator.proposal.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="ri-file-text-line"></i> Detail Proposal</a>
        </div>
    </div>

    <div class="row g-3">
        {{-- Ringkasan + Agregasi --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <p class="text-muted small mb-1">Nilai Akhir (Rata-rata Reviewer)</p>
                    @if ($agregasi['jumlah_selesai'] > 0)
                        <h1 class="text-success mb-0">{{ number_format($agregasi['rata_rata'], 2) }}<small class="text-muted fs-5"> / 100</small></h1>
                        <p class="text-muted small mb-2">Kategori: <strong>{{ $kategori }}</strong></p>
                    @else
                        <h2 class="text-muted mb-2">Belum ada nilai</h2>
                    @endif

                    <hr>
                    <div class="row text-center">
                        <div class="col">
                            <p class="text-muted small mb-1">Reviewer</p>
                            <h5 class="mb-0">{{ $agregasi['jumlah_selesai'] }} / {{ $agregasi['jumlah_reviewer'] }}</h5>
                        </div>
                        <div class="col">
                            <p class="text-muted small mb-1">Status</p>
                            <x-status-badge :status="$p->status" tooltip />
                        </div>
                    </div>

                    <hr>
                    <p class="text-muted small mb-2">Rekomendasi Reviewer:</p>
                    @forelse ($agregasi['rekomendasi_list'] as $rek)
                        @php [$rlbl, $rcls] = $rekomendasiBadge[$rek] ?? [$rek, 'bg-light text-muted']; @endphp
                        <span class="badge {{ $rcls }} mb-1">{{ $rlbl }}</span>
                    @empty
                        <span class="text-muted small">Belum ada</span>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body small">
                    <strong>Identitas Proposal</strong>
                    <hr>
                    <p class="mb-1"><strong>Ketua:</strong> {{ $p->ketua->nama_lengkap }}</p>
                    <p class="mb-1"><strong>Fakultas:</strong> {{ $p->ketua->fakultas?->nama }}</p>
                    <p class="mb-1"><strong>Skema:</strong> {{ $p->skemaHibah->nama }}</p>
                    <p class="mb-1"><strong>Anggaran:</strong> Rp {{ number_format($p->total_anggaran, 0, ',', '.') }}</p>
                    <p class="mb-0"><strong>Durasi:</strong> {{ $p->durasi_bulan }} bulan</p>
                </div>
            </div>
        </div>

        {{-- Penilaian per Reviewer --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Penilaian per Reviewer</h6></div>
                <div class="card-body">
                    @forelse ($p->penugasanReviewer as $pr)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ ucfirst(str_replace('reviewer_', 'Reviewer ', $pr->peran)) }}:</strong>
                                    {{ $pr->reviewer?->nama_lengkap }}
                                </div>
                                @if ($pr->status === 'selesai' && $pr->penilaian)
                                    @php [$rlbl, $rcls] = $rekomendasiBadge[$pr->penilaian->rekomendasi] ?? [$pr->penilaian->rekomendasi, 'bg-light text-muted']; @endphp
                                    <div class="text-end">
                                        <div class="fs-5 fw-bold text-success">{{ number_format($pr->penilaian->nilai_total, 2) }}</div>
                                        <span class="badge {{ $rcls }}">{{ $rlbl }}</span>
                                    </div>
                                @elseif ($pr->penilaian)
                                    <span class="badge bg-warning-subtle text-warning">Menunggu Penilaian Ulang</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Belum Dinilai</span>
                                @endif
                            </div>

                            @if ($pr->status === 'selesai' && $pr->penilaian)
                                <table class="table table-sm mb-2 small">
                                    <thead class="table-light">
                                        <tr><th>Komponen</th><th class="text-center">Skor</th><th class="text-center">Bobot %</th><th class="text-end">Nilai</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pr->penilaian->detail as $d)
                                            <tr>
                                                <td>{{ $d->kriteria->nama }}</td>
                                                <td class="text-center"><span class="badge bg-primary">{{ $d->skor }}</span></td>
                                                <td class="text-center">{{ $d->kriteria->bobot_persen }}</td>
                                                <td class="text-end">{{ number_format(($d->skor / 5) * $d->kriteria->bobot_persen, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="bg-light rounded p-2 small">
                                    <strong>Catatan untuk Peneliti:</strong><br>
                                    {{ $pr->penilaian->catatan_umum }}
                                </div>
                            @else
                                <p class="text-muted small mb-0">
                                    {{ $pr->penilaian ? 'Proposal telah direvisi — menunggu reviewer melakukan penilaian ulang.' : 'Reviewer belum menyelesaikan penilaian.' }}
                                    Deadline: {{ $pr->deadline->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Belum ada reviewer ditugaskan.</p>
                    @endforelse
                </div>
            </div>

            {{-- Form Finalize --}}
            @if ($bisaFinalize && $agregasi['jumlah_selesai'] > 0)
                <div class="card border-0 shadow-sm mt-3 border border-primary border-2">
                    <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="ri-check-double-line me-2"></i>Finalisasi Operator</h6></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('operator.penilaian.finalize', $p) }}">
                            @csrf

                            <label class="form-label">Keputusan Akhir <span class="text-danger">*</span></label>
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="keputusan" id="finalDisetujui" value="disetujui" required>
                                    <label class="btn btn-outline-success w-100 text-start" for="finalDisetujui">
                                        <i class="ri-checkbox-circle-line me-1"></i><strong>Disetujui</strong><br>
                                        <small>Proposal didanai, dosen mulai pelaksanaan.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="keputusan" id="finalMinor" value="revisi_minor">
                                    <label class="btn btn-outline-warning w-100 text-start" for="finalMinor">
                                        <i class="ri-edit-line me-1"></i><strong>Revisi Minor</strong><br>
                                        <small>Perbaikan kecil sebelum disetujui.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="keputusan" id="finalMayor" value="revisi_mayor">
                                    <label class="btn btn-outline-warning w-100 text-start" for="finalMayor">
                                        <i class="ri-edit-2-line me-1"></i><strong>Revisi Mayor</strong><br>
                                        <small>Perbaikan signifikan diperlukan.</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="keputusan" id="finalTolak" value="ditolak">
                                    <label class="btn btn-outline-danger w-100 text-start" for="finalTolak">
                                        <i class="ri-close-circle-line me-1"></i><strong>Tolak</strong><br>
                                        <small>Proposal tidak didanai.</small>
                                    </label>
                                </div>
                            </div>

                            <label class="form-label">Catatan Operator <span class="text-danger">*</span></label>
                            <textarea name="catatan" rows="4" required class="form-control" placeholder="Tuliskan justifikasi keputusan & catatan untuk dosen..."></textarea>

                            <button type="submit" class="btn btn-primary mt-3 w-100">
                                <i class="ri-save-line me-1"></i> Simpan Keputusan Final
                            </button>
                        </form>
                    </div>
                </div>
            @elseif (! $bisaFinalize && $p->status !== 'submitted')
                <div class="alert alert-info mt-3">
                    <i class="ri-information-line me-1"></i> Proposal sudah difinalisasi dengan status <x-status-badge :status="$p->status" />.
                </div>
            @elseif ($agregasi['jumlah_selesai'] === 0)
                <div class="alert alert-warning mt-3">
                    <i class="ri-time-line me-1"></i> Menunggu reviewer menyelesaikan penilaian sebelum dapat difinalisasi.
                </div>
            @endif
        </div>
    </div>
@endsection
