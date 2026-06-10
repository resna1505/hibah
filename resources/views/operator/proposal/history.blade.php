@extends('layouts.operator')

@section('title', 'History Proposal')

@php $activeNav = 'proposal.history'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">History Proposal</h4>
            <p class="text-muted small mb-0">
                Riwayat proposal per periode &middot;
                {{ $periode?->nama ?? ($tahun === 'all' ? 'Semua periode' : 'Periode ' . $tahun) }}
                &middot; {{ $list->total() }} proposal
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small">Periode</label>
                    <select name="tahun" class="form-select form-select-sm">
                        <option value="all" @selected($tahun === 'all')>Semua Periode</option>
                        @foreach ($tahunList as $th)
                            <option value="{{ $th }}" @selected((string) $tahun === (string) $th)>{{ $th }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Cari Judul / Ketua</label>
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Fakultas <span class="text-muted">(ketua/anggota)</span></label>
                    <select name="fakultas_id" id="filterFakultas" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach ($fakultasList as $f)
                            <option value="{{ $f->id }}" @selected(($filters['fakultas_id'] ?? null) == $f->id)>{{ $f->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Program Studi <span class="text-muted">(ketua/anggota)</span></label>
                    <select name="prodi_id" id="filterProdi" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach ($prodiList as $pr)
                            <option value="{{ $pr->id }}" data-fakultas="{{ $pr->fakultas_id }}"
                                @selected(($filters['prodi_id'] ?? null) == $pr->id)>{{ $pr->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach (['draft', 'submitted', 'verifikasi', 'dikembalikan', 'direview', 'revisi_minor', 'revisi_mayor', 'disetujui', 'ditolak', 'berjalan', 'selesai', 'ditarik'] as $st)
                            <option value="{{ $st }}" @selected(($filters['status'] ?? null) === $st)>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Skema</label>
                    <select name="skema_id" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach ($skemaList as $s)
                            <option value="{{ $s->id }}" @selected(($filters['skema_id'] ?? null) == $s->id)>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ri-filter-line"></i> Filter</button>
                    <a href="{{ route('operator.proposal.history') }}" class="btn btn-sm btn-light"><i class="ri-restart-line"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Ketua</th>
                            <th>Fakultas</th>
                            <th>Prodi</th>
                            <th>Skema</th>
                            <th>Periode</th>
                            <th>Tgl Submit</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $i => $p)
                            <tr>
                                <td>{{ $list->firstItem() + $i }}</td>
                                <td class="text-truncate" style="max-width:240px;" title="{{ $p->judul }}">{{ $p->judul ?: '(Belum ada judul)' }}</td>
                                <td class="small">{{ $p->ketua?->nama_lengkap }}</td>
                                <td class="small">{{ $p->ketua?->fakultas?->kode ?? $p->ketua?->fakultas?->nama }}</td>
                                <td class="small">{{ $p->ketua?->prodi?->nama }}</td>
                                <td class="small">{{ $p->skemaHibah?->nama }}</td>
                                <td class="small">{{ $p->periodeHibah?->tahun }}</td>
                                <td class="small">{{ $p->tgl_submit?->format('d M Y') ?? '-' }}</td>
                                <td><x-status-badge :status="$p->status" tooltip /></td>
                                <td class="text-end">
                                    <a href="{{ route('operator.proposal.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-line"></i> Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted py-4">Tidak ada proposal ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">{{ $list->links() }}</div>
    </div>
@endsection

@section('scripts')
<script>
// Filter opsi prodi mengikuti fakultas terpilih
(function () {
    const fak = document.getElementById('filterFakultas');
    const prodi = document.getElementById('filterProdi');
    if (!fak || !prodi) return;
    function syncProdi() {
        const fid = fak.value;
        let resetSelected = false;
        prodi.querySelectorAll('option').forEach(opt => {
            if (!opt.value) return; // opsi "Semua"
            const match = !fid || opt.dataset.fakultas === fid;
            opt.hidden = !match;
            if (!match && opt.selected) resetSelected = true;
        });
        if (resetSelected) prodi.value = '';
    }
    fak.addEventListener('change', syncProdi);
    syncProdi();
})();
</script>
@endsection
