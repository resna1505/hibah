@extends('layouts.dosen')

@section('title', 'Usulan PKM')

@php $activeNav = 'pengabdian'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Usulan PKM</h4>
            <p class="text-muted small mb-0">Kelola proposal Pengabdian Kepada Masyarakat yang Anda ajukan</p>
        </div>
        <a href="{{ route('dosen.pkm.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Ajukan PKM Baru
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
                                <td><x-status-badge :status="$p->status" /></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('dosen.pkm.show', $p) }}" class="btn btn-outline-primary"><i class="ri-eye-line"></i></a>
                                        @if (in_array($p->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                                            <a href="{{ route('dosen.pkm.edit', $p) }}" class="btn btn-outline-warning"><i class="ri-edit-line"></i></a>
                                        @endif
                                        <a href="{{ route('dosen.pkm.pdf', $p) }}" class="btn btn-outline-secondary"><i class="ri-download-line"></i></a>
                                        @if ($p->status === 'draft')
                                            <form method="POST" action="{{ route('dosen.pkm.destroy', $p) }}" class="d-inline"
                                                onsubmit="return confirm('Hapus draft proposal ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="ri-community-line fs-1 d-block mb-2"></i>
                                    Anda belum punya usulan PKM.
                                    <br>
                                    <a href="{{ route('dosen.pkm.create') }}" class="btn btn-sm btn-primary mt-2">Ajukan Sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
