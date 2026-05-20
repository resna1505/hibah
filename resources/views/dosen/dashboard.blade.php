@extends('layouts.master-without-nav')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="min-vh-100 bg-light py-4">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-primary text-white rounded mb-4 px-3">
            <span class="navbar-brand text-white fw-bold">LPPM UNIVERSITAS BATAM</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-light text-primary">DOSEN</span>
                @if ($dosen?->is_reviewer)
                    <a href="{{ route('reviewer.dashboard') }}" class="btn btn-sm btn-warning">Mode Reviewer</a>
                @endif
                <span class="text-white small">{{ $dosen?->nama_lengkap ?? $user->nik }}</span>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-light">Keluar</a>
            </div>
        </nav>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang, {{ $dosen?->nama_lengkap ?? 'Dosen' }}!</h4>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Profil Saya</h6>
                        <ul class="list-unstyled small">
                            <li><strong>NIK:</strong> {{ $user->nik }}</li>
                            <li><strong>NIDN:</strong> {{ $dosen?->nidn ?? '-' }}</li>
                            <li><strong>Fakultas:</strong> {{ $dosen?->fakultas?->nama ?? '-' }}</li>
                            <li><strong>Program Studi:</strong> {{ $dosen?->prodi?->nama ?? '-' }}</li>
                            <li><strong>Jabatan:</strong> {{ $dosen?->jabatan_fungsional ?? '-' }}</li>
                            <li><strong>Sinta Score:</strong> {{ $dosen?->sinta_score ?? 0 }}</li>
                            <li><strong>Reviewer aktif:</strong> {{ $dosen?->is_reviewer ? 'Ya' : 'Tidak' }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info mb-0">
                            <strong>Status auth flow: OK</strong><br>
                            Modul Dosen (Penelitian, Pengabdian/PKM, Laporan) akan dibangun bertahap.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
