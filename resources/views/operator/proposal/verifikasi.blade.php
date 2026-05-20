@extends('layouts.operator')

@section('title', 'Verifikasi Proposal')

@php $activeNav = 'proposal.verifikasi'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Verifikasi Proposal</h4>
            <p class="text-muted small mb-0">{{ $p->judul }}</p>
        </div>
        <a href="{{ route('operator.proposal.show', $p) }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Detail Lengkap</a>
    </div>

    <div class="row g-3">
        {{-- Ringkasan Proposal --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Ringkasan Proposal</h6></div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><td width="30%" class="text-muted">Ketua</td><td>{{ $p->ketua->nama_lengkap }}</td></tr>
                        <tr><td class="text-muted">NIDN</td><td>{{ $p->ketua->nidn ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Fakultas / Prodi</td><td>{{ $p->ketua->fakultas?->nama }} / {{ $p->ketua->prodi?->nama }}</td></tr>
                        <tr><td class="text-muted">Skema</td><td>{{ $p->skemaHibah->nama }}</td></tr>
                        <tr><td class="text-muted">Total Anggaran</td><td><strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong> / max Rp {{ number_format($p->skemaHibah->max_anggaran, 0, ',', '.') }}</td></tr>
                        <tr><td class="text-muted">Durasi</td><td>{{ $p->durasi_bulan }} bulan</td></tr>
                        <tr><td class="text-muted">Tgl Submit</td><td>{{ $p->tgl_submit?->format('d M Y H:i') ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white"><h6 class="mb-0">Cek Kelengkapan</h6></div>
                <div class="card-body">
                    @php
                        $checks = [
                            'Judul' => ! empty($p->judul),
                            'Ringkasan' => ! empty($p->ringkasan),
                            'Pendahuluan' => ! empty($p->pendahuluan),
                            'Metode' => ! empty($p->metode),
                            'Daftar Pustaka' => ! empty($p->daftar_pustaka),
                            'RAB' => $p->rab->count() > 0,
                            'Anggota Tim' => $p->anggota->count() > 0,
                            'Total RAB ≤ Max' => $totalRab <= $p->skemaHibah->max_anggaran,
                            'Pernyataan Setuju' => $p->pernyataan_setuju,
                        ];
                        if ($p->skemaHibah->jenis === 'pkm') {
                            $checks['Mitra (PKM)'] = $p->mitra()->count() > 0;
                            $checks['Permasalahan & Solusi'] = ! empty($p->permasalahan_solusi);
                        }
                    @endphp
                    <ul class="list-unstyled mb-0">
                        @foreach ($checks as $item => $ok)
                            <li class="mb-1">
                                @if ($ok)
                                    <i class="ri-checkbox-circle-fill text-success me-1"></i>
                                @else
                                    <i class="ri-close-circle-fill text-danger me-1"></i>
                                @endif
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if ($lastVerif)
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Verifikasi Sebelumnya</h6></div>
                    <div class="card-body small">
                        <strong>{{ ucfirst($lastVerif->status) }}</strong> &mdash; {{ $lastVerif->tgl_verifikasi->format('d M Y H:i') }}<br>
                        @if ($lastVerif->catatan)<p class="text-muted mt-2 mb-0">{{ $lastVerif->catatan }}</p>@endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Form Keputusan --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Keputusan Verifikasi</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('operator.proposal.verifikasi.submit', $p) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                            <div class="d-grid gap-2">
                                <input type="radio" class="btn-check" name="keputusan" id="kepLengkap" value="lengkap" required>
                                <label class="btn btn-outline-success text-start" for="kepLengkap">
                                    <i class="ri-checkbox-circle-line me-2"></i>
                                    <strong>Lengkap</strong> &mdash; Proposal valid, lanjut ke tahap review.
                                </label>

                                <input type="radio" class="btn-check" name="keputusan" id="kepKembali" value="dikembalikan">
                                <label class="btn btn-outline-warning text-start" for="kepKembali">
                                    <i class="ri-refresh-line me-2"></i>
                                    <strong>Dikembalikan</strong> &mdash; Ada yang perlu diperbaiki dosen.
                                </label>

                                <input type="radio" class="btn-check" name="keputusan" id="kepTolak" value="ditolak">
                                <label class="btn btn-outline-danger text-start" for="kepTolak">
                                    <i class="ri-close-circle-line me-2"></i>
                                    <strong>Tolak</strong> &mdash; Tidak memenuhi syarat.
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan <span class="text-danger">*</span></label>
                            <textarea name="catatan" rows="5" required class="form-control" placeholder="Tuliskan catatan untuk dosen pengusul..."></textarea>
                            <small class="text-muted">Catatan akan ditampilkan kepada dosen.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-save-line me-1"></i> Simpan Keputusan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
