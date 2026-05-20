@extends('layouts.reviewer')

@section('title', 'Dashboard Reviewer')

@php $activeNav = 'dashboard'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Dashboard Reviewer</h4>
            <p class="text-muted mb-0 small">Halo, {{ $dosen?->nama_lengkap }}</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6>Profil Reviewer</h6>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled small">
                        <li class="mb-2"><strong>NIK:</strong> {{ $user->nik }}</li>
                        <li class="mb-2"><strong>NIDN:</strong> {{ $dosen?->nidn ?? '-' }}</li>
                        <li class="mb-2"><strong>Fakultas:</strong> {{ $dosen?->fakultas?->nama ?? '-' }}</li>
                        <li class="mb-2"><strong>Program Studi:</strong> {{ $dosen?->prodi?->nama ?? '-' }}</li>
                        <li class="mb-2"><strong>Bidang Keahlian:</strong></li>
                        <li>
                            @forelse ($dosen?->keahlian ?? [] as $k)
                                <span class="badge bg-primary-subtle text-primary me-1">{{ $k->nama }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-warning mb-0">
                        <i class="ri-information-line me-1"></i>
                        Modul Reviewer (Proposal, Penilaian, Hasil Review, Jadwal Review) akan dibangun bertahap.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
