@extends('layouts.operator')

@section('title', 'Pengaturan')

@php $activeNav = 'pengaturan'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Pengaturan Sistem</h4>
            <p class="text-muted small mb-0">Identitas Ketua LPPM, institusi, dan aset cetak (digunakan di lembar pengesahan PDF)</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('operator.pengaturan.update') }}" enctype="multipart/form-data">
        @csrf

        @foreach ($grouped as $grup => $items)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="ri-settings-3-line text-primary me-2"></i>{{ ucfirst($grup) }}</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($items as $it)
                            <div class="col-md-6">
                                <label class="form-label">{{ $it->label ?? $it->kunci }}</label>
                                @if ($it->tipe === 'image')
                                    @if ($it->nilai)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $it->nilai) }}" style="max-height:80px;" class="border rounded">
                                        </div>
                                    @endif
                                    @if ($it->kunci === 'lppm_ttd_path')
                                        <input type="file" name="lppm_ttd" class="form-control" accept="image/png,image/jpeg">
                                        <small class="text-muted">Tanda tangan (PNG transparan disarankan, maks 1MB)</small>
                                    @elseif ($it->kunci === 'lppm_kop_path')
                                        <input type="file" name="lppm_kop" class="form-control" accept="image/png,image/jpeg">
                                        <small class="text-muted">Kop surat (maks 1MB)</small>
                                    @endif
                                @else
                                    <input type="text" name="nilai[{{ $it->kunci }}]" class="form-control"
                                        value="{{ old('nilai.' . $it->kunci, $it->nilai) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
