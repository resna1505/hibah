@extends('layouts.master-without-nav')

@section('title', 'Dashboard Reviewer')

@section('content')
<div class="min-vh-100 bg-light py-4">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-warning text-dark rounded mb-4 px-3">
            <span class="navbar-brand text-dark fw-bold">UNIVERSITAS BATAM &mdash; Hibah Internal</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-dark text-warning">REVIEWER</span>
                <a href="{{ route('dosen.dashboard') }}" class="btn btn-sm btn-dark">Mode Dosen</a>
                <span class="text-dark small">{{ $dosen?->nama_lengkap ?? $user->nik }}</span>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-light">Keluar</a>
            </div>
        </nav>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dashboard Reviewer</h4>
                <p class="text-muted">Halo, <strong>{{ $dosen?->nama_lengkap }}</strong> &mdash; Anda login sebagai reviewer.</p>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Profil Reviewer</h6>
                        <ul class="list-unstyled small">
                            <li><strong>NIK:</strong> {{ $user->nik }}</li>
                            <li><strong>NIDN:</strong> {{ $dosen?->nidn ?? '-' }}</li>
                            <li><strong>Fakultas:</strong> {{ $dosen?->fakultas?->nama ?? '-' }}</li>
                            <li><strong>Bidang Keahlian:</strong>
                                @forelse ($dosen?->keahlian ?? [] as $k)
                                    <span class="badge bg-soft-primary text-primary me-1">{{ $k->nama }}</span>
                                @empty
                                    -
                                @endforelse
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning mb-0">
                            <strong>Status auth flow: OK</strong><br>
                            Modul Reviewer (Proposal, Penilaian, Hasil Review, Jadwal Review) akan dibangun bertahap.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
