@extends('layouts.operator')

@section('title', 'Verifikasi Laporan')

@php
    $activeNav = 'laporan';

    $statusProposalBadge = [
        'disetujui' => ['Disetujui', 'bg-success-subtle text-success'],
        'berjalan'  => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai'   => ['Selesai', 'bg-info-subtle text-info'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Verifikasi Laporan</h4>
            <p class="text-muted small mb-0">{{ $periodeAktif?->nama ?? 'Belum ada periode aktif' }} &middot; Verifikasi upload laporan dosen</p>
        </div>
    </div>

    {{-- Stats menunggu --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body"><p class="text-muted small mb-1">Total Menunggu</p><h3 class="text-warning mb-0">{{ $stats['total_menunggu'] }}</h3></div>
            </div>
        </div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Laporan Kemajuan</p><h4 class="mb-0">{{ $stats['menunggu_kemajuan'] }}</h4><small class="text-muted">menunggu</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Laporan Akhir</p><h4 class="mb-0">{{ $stats['menunggu_akhir'] }}</h4><small class="text-muted">menunggu</small></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><p class="text-muted small mb-1">Luaran</p><h4 class="mb-0">{{ $stats['menunggu_luaran'] }}</h4><small class="text-muted">menunggu</small></div></div></div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small">Cari Judul / Ketua</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.laporan.index') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul Proposal</th>
                            <th>Ketua</th>
                            <th>Status Hibah</th>
                            <th class="text-center">Kemajuan</th>
                            <th class="text-center">Akhir</th>
                            <th class="text-center">Luaran</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php
                                [$slbl, $scls] = $statusProposalBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];

                                $kMenunggu = $p->laporanKemajuan->where('status', 'menunggu')->count();
                                $kTerverif = $p->laporanKemajuan->where('status', 'terverifikasi')->count();
                                $kTotal    = $p->laporanKemajuan->count();

                                $aStatus = $p->laporanAkhir?->status;
                                $lMenunggu = $p->luaran->where('status', 'menunggu')->count();
                                $lTerverif = $p->luaran->where('status', 'terverifikasi')->count();
                            @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td><span class="badge {{ $scls }}">{{ $slbl }}</span></td>
                                <td class="text-center">
                                    @if ($kTotal > 0)
                                        <span class="badge bg-light text-dark">{{ $kTerverif }}/{{ $kTotal }}</span>
                                        @if ($kMenunggu > 0)<br><span class="badge bg-warning-subtle text-warning small">{{ $kMenunggu }} menunggu</span>@endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($aStatus === 'terverifikasi')
                                        <span class="badge bg-success-subtle text-success">✓ Terverifikasi</span>
                                    @elseif ($aStatus === 'menunggu')
                                        <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                                    @elseif ($aStatus === 'ditolak')
                                        <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($p->luaran->count() > 0)
                                        <span class="badge bg-light text-dark">{{ $lTerverif }}/{{ $p->luaran->count() }}</span>
                                        @if ($lMenunggu > 0)<br><span class="badge bg-warning-subtle text-warning small">{{ $lMenunggu }} menunggu</span>@endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('operator.laporan.show', $p) }}" class="btn btn-sm btn-primary"><i class="ri-eye-line"></i> Verifikasi</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada proposal disetujui yang punya laporan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection
