@extends('layouts.operator')

@section('title', 'Verifikasi Laporan — ' . $p->judul)

@php
    $activeNav = 'laporan';

    $statusBadge = [
        'menunggu'      => ['Menunggu Verifikasi', 'bg-warning-subtle text-warning'],
        'terverifikasi' => ['Terverifikasi', 'bg-success-subtle text-success'],
        'ditolak'       => ['Ditolak', 'bg-danger-subtle text-danger'],
        'belum_unggah'  => ['Belum Unggah', 'bg-secondary-subtle text-secondary'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Verifikasi Laporan</h4>
            <p class="text-muted small mb-0">{{ $p->judul }}</p>
        </div>
        <a href="{{ route('operator.laporan.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><small class="text-muted">Ketua</small><br><strong>{{ $p->ketua->nama_lengkap }}</strong></div>
                <div class="col-md-3"><small class="text-muted">Skema</small><br>{{ $p->skemaHibah->nama }}</div>
                <div class="col-md-3"><small class="text-muted">Anggaran</small><br>Rp {{ number_format($p->total_anggaran, 0, ',', '.') }}</div>
                <div class="col-md-3"><small class="text-muted">Status Hibah</small><br><span class="badge bg-primary-subtle text-primary">{{ ucfirst($p->status) }}</span></div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabKemajuan">Laporan Kemajuan ({{ $p->laporanKemajuan->count() }})</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAkhir">Laporan Akhir</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabLuaran">Luaran ({{ $p->luaran->count() }})</button></li>
    </ul>

    <div class="tab-content">
        {{-- TAB: LAPORAN KEMAJUAN --}}
        <div class="tab-pane fade show active" id="tabKemajuan">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light"><tr><th>Periode</th><th>Tgl Unggah</th><th>Status</th><th>Verifikator</th><th>Catatan</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($p->laporanKemajuan as $lap)
                                @php [$lbl, $cls] = $statusBadge[$lap->status] ?? [$lap->status, 'bg-light text-muted']; @endphp
                                <tr>
                                    <td>{{ $lap->periodeLaporan?->label ?? '-' }}</td>
                                    <td class="small">{{ $lap->tgl_unggah->format('d M Y H:i') }}</td>
                                    <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                    <td class="small">{{ $lap->verifikator?->username ?? '-' }}</td>
                                    <td class="small text-muted text-truncate" style="max-width:200px;">{{ $lap->catatan_verifikator ?? '-' }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ asset('storage/' . $lap->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i></a>
                                            <button class="btn btn-sm {{ $lap->status === 'terverifikasi' ? 'btn-outline-warning' : 'btn-warning' }}" data-bs-toggle="modal" data-bs-target="#mKem{{ $lap->id }}">
                                                <i class="ri-checkbox-line"></i> {{ $lap->status === 'menunggu' ? 'Verify' : 'Ubah' }}
                                            </button>
                                        </div>

                                        <div class="modal fade" id="mKem{{ $lap->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('operator.laporan.verifikasi-kemajuan', $lap) }}">
                                                        @csrf
                                                        <div class="modal-header"><h6 class="modal-title">Verifikasi: {{ $lap->periodeLaporan?->label }}</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                        <div class="modal-body text-start">
                                                            <p class="small text-muted">Buka file lalu putuskan:</p>
                                                            <a href="{{ asset('storage/' . $lap->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-3"><i class="ri-download-line"></i> Buka File</a>

                                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                                            <div class="d-grid gap-2 mb-3">
                                                                <input type="radio" class="btn-check" name="status" id="kemOk{{ $lap->id }}" value="terverifikasi" required>
                                                                <label class="btn btn-outline-success text-start" for="kemOk{{ $lap->id }}"><i class="ri-checkbox-circle-line me-1"></i> Terverifikasi</label>
                                                                <input type="radio" class="btn-check" name="status" id="kemNo{{ $lap->id }}" value="ditolak">
                                                                <label class="btn btn-outline-danger text-start" for="kemNo{{ $lap->id }}"><i class="ri-close-circle-line me-1"></i> Ditolak</label>
                                                            </div>
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="catatan" rows="3" class="form-control">{{ $lap->catatan_verifikator }}</textarea>
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada laporan kemajuan diunggah.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB: LAPORAN AKHIR --}}
        <div class="tab-pane fade" id="tabAkhir">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if ($p->laporanAkhir)
                        @php $la = $p->laporanAkhir; [$lbl, $cls] = $statusBadge[$la->status] ?? [$la->status, 'bg-light text-muted']; @endphp
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-1"><i class="ri-file-text-line me-1"></i> Laporan akhir diunggah <strong>{{ $la->tgl_unggah->format('d M Y H:i') }}</strong></p>
                                <span class="badge {{ $cls }}">{{ $lbl }}</span>
                                @if ($la->catatan_verifikator)<p class="text-muted small mt-2 mb-0">Catatan: {{ $la->catatan_verifikator }}</p>@endif
                                @if ($la->verifikator)<p class="text-muted small mb-0">Diverifikasi oleh: {{ $la->verifikator->username }}</p>@endif
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ asset('storage/' . $la->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i> Buka File</a>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#mAkhir"><i class="ri-checkbox-line"></i> Verifikasi</button>
                            </div>
                        </div>

                        <div class="modal fade" id="mAkhir" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('operator.laporan.verifikasi-akhir', $la) }}">
                                        @csrf
                                        <div class="modal-header"><h6 class="modal-title">Verifikasi Laporan Akhir</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                        <div class="modal-body text-start">
                                            <p class="text-muted small">Verifikasi laporan akhir akan otomatis mengubah status proposal menjadi <strong>Selesai</strong>.</p>
                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                            <div class="d-grid gap-2 mb-3">
                                                <input type="radio" class="btn-check" name="status" id="akhirOk" value="terverifikasi" required>
                                                <label class="btn btn-outline-success text-start" for="akhirOk"><i class="ri-checkbox-circle-line me-1"></i> Terverifikasi (proposal → Selesai)</label>
                                                <input type="radio" class="btn-check" name="status" id="akhirNo" value="ditolak">
                                                <label class="btn btn-outline-danger text-start" for="akhirNo"><i class="ri-close-circle-line me-1"></i> Ditolak</label>
                                            </div>
                                            <label class="form-label">Catatan</label>
                                            <textarea name="catatan" rows="3" class="form-control">{{ $la->catatan_verifikator }}</textarea>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="ri-file-text-line fs-1 d-block mb-2"></i>
                            Dosen belum mengunggah laporan akhir.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB: LUARAN --}}
        <div class="tab-pane fade" id="tabLuaran">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light"><tr><th>Jenis Luaran</th><th>Tgl Unggah</th><th>Status</th><th>Catatan</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($p->luaran as $l)
                                @php [$lbl, $cls] = $statusBadge[$l->status] ?? [$l->status, 'bg-light text-muted']; @endphp
                                <tr>
                                    <td>
                                        {{ $l->jenisLuaran?->nama }}
                                        @if ($l->link_url)<br><a href="{{ $l->link_url }}" target="_blank" class="small"><i class="ri-link"></i> {{ $l->link_url }}</a>@endif
                                    </td>
                                    <td class="small">{{ $l->tgl_unggah?->format('d M Y') ?? '-' }}</td>
                                    <td><span class="badge {{ $cls }}">{{ $lbl }}</span></td>
                                    <td class="small text-muted text-truncate" style="max-width:200px;">{{ $l->catatan_verifikator ?? '-' }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            @if ($l->file_path)
                                                <a href="{{ asset('storage/' . $l->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i></a>
                                            @endif
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#mLuar{{ $l->id }}"><i class="ri-checkbox-line"></i> Verify</button>
                                        </div>

                                        <div class="modal fade" id="mLuar{{ $l->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('operator.laporan.verifikasi-luaran', $l) }}">
                                                        @csrf
                                                        <div class="modal-header"><h6 class="modal-title">Verifikasi: {{ $l->jenisLuaran?->nama }}</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                        <div class="modal-body text-start">
                                                            @if ($l->file_path)
                                                                <a href="{{ asset('storage/' . $l->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-3"><i class="ri-download-line"></i> Buka File</a>
                                                            @endif
                                                            @if ($l->link_url)
                                                                <p class="small mb-3"><a href="{{ $l->link_url }}" target="_blank">{{ $l->link_url }}</a></p>
                                                            @endif

                                                            <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                                            <div class="d-grid gap-2 mb-3">
                                                                <input type="radio" class="btn-check" name="status" id="luarOk{{ $l->id }}" value="terverifikasi" required>
                                                                <label class="btn btn-outline-success text-start" for="luarOk{{ $l->id }}"><i class="ri-checkbox-circle-line me-1"></i> Terverifikasi</label>
                                                                <input type="radio" class="btn-check" name="status" id="luarNo{{ $l->id }}" value="ditolak">
                                                                <label class="btn btn-outline-danger text-start" for="luarNo{{ $l->id }}"><i class="ri-close-circle-line me-1"></i> Ditolak</label>
                                                            </div>
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="catatan" rows="3" class="form-control">{{ $l->catatan_verifikator }}</textarea>
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada luaran diunggah.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
