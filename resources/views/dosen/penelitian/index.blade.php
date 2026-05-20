@extends('layouts.dosen')

@section('title', 'Usulan Penelitian')

@php
    $activeNav = 'penelitian';

    $statusBadge = [
        'draft'        => ['Draft', 'bg-secondary-subtle text-secondary'],
        'submitted'    => ['Menunggu Verifikasi', 'bg-info-subtle text-info'],
        'verifikasi'   => ['Verifikasi', 'bg-info-subtle text-info'],
        'dikembalikan' => ['Dikembalikan', 'bg-warning-subtle text-warning'],
        'direview'     => ['Sedang Direview', 'bg-info-subtle text-info'],
        'revisi_minor' => ['Revisi Minor', 'bg-warning-subtle text-warning'],
        'revisi_mayor' => ['Revisi Mayor', 'bg-warning-subtle text-warning'],
        'disetujui'    => ['Disetujui', 'bg-success-subtle text-success'],
        'ditolak'      => ['Ditolak', 'bg-danger-subtle text-danger'],
        'berjalan'     => ['Berjalan', 'bg-primary-subtle text-primary'],
        'selesai'      => ['Selesai', 'bg-success-subtle text-success'],
        'ditarik'      => ['Ditarik', 'bg-secondary-subtle text-secondary'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Usulan Penelitian</h4>
            <p class="text-muted small mb-0">Kelola proposal penelitian yang Anda ajukan</p>
        </div>
        <a href="{{ route('dosen.penelitian.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Ajukan Proposal Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Periode</th>
                            <th>Anggaran</th>
                            <th>Tanggal Submit</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="text-truncate" style="max-width:300px;" title="{{ $p->judul }}">{{ $p->judul ?: '(Belum ada judul)' }}</td>
                                <td class="small">{{ $p->periodeHibah?->nama }}</td>
                                <td class="small">Rp {{ number_format($p->total_anggaran, 0, ',', '.') }}</td>
                                <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    @php [$label, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted']; @endphp
                                    <span class="badge {{ $cls }}">{{ $label }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('dosen.penelitian.show', $p) }}" class="btn btn-outline-primary" title="Lihat"><i class="ri-eye-line"></i></a>
                                        @if (in_array($p->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                                            <a href="{{ route('dosen.penelitian.edit', $p) }}" class="btn btn-outline-warning" title="Edit"><i class="ri-edit-line"></i></a>
                                        @endif
                                        <a href="{{ route('dosen.penelitian.pdf', $p) }}" class="btn btn-outline-secondary" title="Unduh PDF"><i class="ri-download-line"></i></a>
                                        @if ($p->status === 'draft')
                                            <form method="POST" action="{{ route('dosen.penelitian.destroy', $p) }}" class="d-inline"
                                                onsubmit="return confirm('Hapus draft proposal ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="ri-file-text-line fs-1 d-block mb-2"></i>
                                    Anda belum punya usulan penelitian.
                                    <br>
                                    <a href="{{ route('dosen.penelitian.create') }}" class="btn btn-sm btn-primary mt-2">Ajukan Sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
