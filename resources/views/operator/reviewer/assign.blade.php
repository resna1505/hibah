@extends('layouts.operator')

@section('title', 'Tugaskan Reviewer')

@php $activeNav = 'reviewer.penugasan'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Tugaskan Reviewer</h4>
            <p class="text-muted small mb-0">{{ $p->judul }}</p>
        </div>
        <a href="{{ route('operator.reviewer.penugasan') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Detail Proposal</h6></div>
                <div class="card-body small">
                    <p class="mb-1"><strong>{{ $p->judul }}</strong></p>
                    <p class="mb-1"><strong>Ketua:</strong> {{ $p->ketua?->nama_lengkap }}</p>
                    <p class="mb-1"><strong>Fakultas:</strong> {{ $p->ketua?->fakultas?->nama }}</p>
                    <p class="mb-1"><strong>Skema:</strong> {{ $p->skemaHibah?->nama }}</p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-info-subtle text-info">{{ ucfirst($p->status) }}</span></p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Pilih Reviewer</h6></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('operator.reviewer.assign.submit', $p) }}">
                        @csrf

                        @php
                            $r1 = $currentAssignments['reviewer_1'] ?? null;
                            $r2 = $currentAssignments['reviewer_2'] ?? null;
                            $deadline = $r1?->deadline ?? now()->addDays(14)->toDateString();
                        @endphp

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Reviewer <span class="text-danger">*</span></label>
                                <select name="reviewer_1_id" required class="form-select">
                                    <option value="">-- Pilih Reviewer --</option>
                                    @foreach ($reviewerTersedia as $r)
                                        <option value="{{ $r->id }}" @selected($r1?->reviewer_dosen_id == $r->id)>
                                            {{ $r->nama_lengkap }} &mdash; {{ $r->fakultas?->kode }}
                                            @if ($r->keahlian->count()) ({{ $r->keahlian->take(2)->pluck('nama')->implode(', ') }})@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deadline Review <span class="text-danger">*</span></label>
                                <input type="date" name="deadline" required class="form-control"
                                    value="{{ $deadline instanceof \Carbon\Carbon ? $deadline->toDateString() : $deadline }}"
                                    min="{{ now()->addDay()->toDateString() }}">
                            </div>
                        </div>

                        <hr>
                        <p class="text-muted small">Reviewer yang muncul: dosen yang flag `is_reviewer=true`, bukan ketua/anggota proposal, dan masih aktif mengajar.</p>

                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Simpan Penugasan
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white"><h6 class="mb-0">Reviewer Tersedia ({{ $reviewerTersedia->count() }})</h6></div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach ($reviewerTersedia as $r)
                            <div class="col-md-6">
                                <div class="border rounded p-2 small">
                                    <strong>{{ $r->nama_lengkap }}</strong><br>
                                    <span class="text-muted">{{ $r->fakultas?->nama }} &middot; {{ $r->prodi?->nama }}</span><br>
                                    @foreach ($r->keahlian->take(3) as $k)
                                        <span class="badge bg-light text-dark mt-1">{{ $k->nama }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
