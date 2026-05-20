@extends('layouts.operator')

@section('title', 'Jadwal Hibah')

@php
    $activeNav = 'jadwal';
    $statusBadge = [
        'draft'   => ['Draft', 'bg-secondary-subtle text-secondary'],
        'aktif'   => ['Aktif', 'bg-success-subtle text-success'],
        'selesai' => ['Selesai', 'bg-info-subtle text-info'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Jadwal Hibah</h4>
            <p class="text-muted small mb-0">Kelola periode hibah, tahapan, dan jadwal laporan</p>
        </div>
        <a href="{{ route('operator.jadwal.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Periode Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tahun</th>
                            <th>Nama Periode</th>
                            <th class="text-center">Tahapan</th>
                            <th class="text-center">Proposal</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            @php [$lbl, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted']; @endphp
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td><strong>{{ $p->tahun }}</strong></td>
                                <td>{{ $p->nama }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark">{{ $p->jadwal_tahapan_count }}</span></td>
                                <td class="text-center"><span class="badge bg-light text-dark">{{ $p->proposal_count }}</span></td>
                                <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('operator.jadwal.edit', $p) }}" class="btn btn-outline-primary"><i class="ri-edit-line"></i> Edit</a>
                                        @if ($p->status !== 'aktif')
                                            <form method="POST" action="{{ route('operator.jadwal.activate', $p) }}" class="d-inline"
                                                onsubmit="return confirm('Aktifkan periode ini? Periode aktif lain akan diubah ke Selesai.');">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-success"><i class="ri-checkbox-circle-line"></i> Aktifkan</button>
                                            </form>
                                        @endif
                                        @if ($p->proposal_count === 0)
                                            <form method="POST" action="{{ route('operator.jadwal.destroy', $p) }}" class="d-inline"
                                                onsubmit="return confirm('Hapus periode {{ $p->nama }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-5">
                                <i class="ri-calendar-line fs-1 d-block mb-2"></i>
                                Belum ada periode hibah.
                                <br><a href="{{ route('operator.jadwal.create') }}" class="btn btn-sm btn-primary mt-2">Buat Periode Pertama</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>

    @php
        $periodeAktif = $list->where('status', 'aktif')->first();
        if ($periodeAktif) {
            $periodeAktif->load(['jadwalTahapan.tahapanHibah' => fn($q) => $q->orderBy('urutan')]);
        }
    @endphp
    @if ($periodeAktif && $periodeAktif->jadwalTahapan->count() > 0)
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0">Timeline Tahapan Periode Aktif ({{ $periodeAktif->nama }})</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                    @foreach ($periodeAktif->jadwalTahapan->sortBy('tahapanHibah.urutan') as $j)
                        @php
                            $iconMap = [
                                'pengajuan' => 'ri-file-text-line',
                                'review' => 'ri-team-line',
                                'revisi' => 'ri-edit-line',
                                'penetapan' => 'ri-checkbox-circle-line',
                                'pengumuman' => 'ri-megaphone-line',
                                'pelaksanaan' => 'ri-briefcase-line',
                            ];
                            $kode = $j->tahapanHibah?->kode ?? '';
                            $icon = $iconMap[$kode] ?? 'ri-calendar-line';
                            $cls = match ($j->status) {
                                'selesai' => 'bg-success text-white',
                                'berjalan' => 'bg-warning text-dark',
                                default => 'bg-light text-muted',
                            };
                            $isLast = $loop->last;
                        @endphp
                        <div class="text-center" style="flex:1; min-width:120px;">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 {{ $cls }}" style="width:54px;height:54px;">
                                <i class="{{ $icon }} fs-4"></i>
                            </div>
                            <p class="fw-medium mb-0 small">{{ $j->tahapanHibah?->nama }}</p>
                            <small class="text-muted">{{ $j->tgl_mulai?->format('d M') }} - {{ $j->tgl_selesai?->format('d M Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
