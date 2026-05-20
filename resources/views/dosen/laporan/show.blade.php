@extends('layouts.dosen')

@section('title', 'Laporan ' . ($proposal->skemaHibah->jenis === 'pkm' ? 'PKM' : 'Penelitian'))

@php
    $isPkm = $proposal->skemaHibah->jenis === 'pkm';
    $activeNav = $isPkm ? 'pengabdian' : 'penelitian';
    $usulanRoute = $isPkm ? 'dosen.pkm.show' : 'dosen.penelitian.show';

    $statusLaporan = [
        'menunggu'      => ['Menunggu Verifikasi', 'bg-info-subtle text-info'],
        'terverifikasi' => ['Terverifikasi', 'bg-success-subtle text-success'],
        'ditolak'       => ['Ditolak', 'bg-danger-subtle text-danger'],
        'belum_unggah'  => ['Belum Unggah', 'bg-secondary-subtle text-secondary'],
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Laporan {{ $isPkm ? 'PKM' : 'Penelitian' }}</h4>
            <p class="text-muted small mb-0">{{ $proposal->judul }}</p>
        </div>
        <a href="{{ route($usulanRoute, $proposal) }}" class="btn btn-sm btn-outline-secondary">
            <i class="ri-arrow-left-line"></i> Detail Proposal
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"><small class="text-muted">Judul</small><br>{{ $proposal->judul }}</div>
                <div class="col-md-3"><small class="text-muted">Skema</small><br>{{ $proposal->skemaHibah->nama }}</div>
                <div class="col-md-3"><small class="text-muted">Tahun</small><br>{{ $proposal->periodeHibah->tahun }}</div>
                <div class="col-md-3"><small class="text-muted">Status Hibah</small><br><span class="badge bg-primary-subtle text-primary">{{ ucfirst($proposal->status) }}</span></div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabKemajuan">Laporan Kemajuan</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAkhir">Laporan Akhir</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabLuaran">Luaran {{ $isPkm ? 'PKM' : 'Penelitian' }}</button></li>
    </ul>

    <div class="tab-content">
        {{-- Tab: Laporan Kemajuan --}}
        <div class="tab-pane fade show active" id="tabKemajuan">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Laporan Kemajuan</h6>
                    <small class="text-muted">Unggah laporan kemajuan sesuai periode yang ditetapkan operator.</small>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr><th>#</th><th>Periode</th><th>Batas Unggah</th><th>Tanggal Unggah</th><th>Status</th><th class="text-end">Aksi</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($periodeLaporan as $i => $pl)
                                @php $lap = $kemajuanByPeriode[$pl->id] ?? null; @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $pl->label }}</td>
                                    <td class="small">{{ $pl->batas_unggah->format('d M Y') }}</td>
                                    <td class="small">{{ $lap?->tgl_unggah?->format('d M Y') ?? '-' }}</td>
                                    <td>
                                        @php
                                            $key = $lap?->status ?? 'belum_unggah';
                                            [$label, $cls] = $statusLaporan[$key] ?? [$key, 'bg-light text-muted'];
                                        @endphp
                                        <span class="badge {{ $cls }}">{{ $label }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            @if ($lap?->file_path)
                                                <a href="{{ asset('storage/' . $lap->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i></a>
                                            @endif
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mKem{{ $pl->id }}">
                                                <i class="ri-upload-line"></i> {{ $lap ? 'Update' : 'Upload' }}
                                            </button>
                                        </div>

                                        {{-- Modal upload --}}
                                        <div class="modal fade" id="mKem{{ $pl->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('dosen.laporan.kemajuan', $proposal) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="periode_laporan_id" value="{{ $pl->id }}">
                                                        <div class="modal-header"><h6 class="modal-title">Upload {{ $pl->label }}</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                        <div class="modal-body text-start">
                                                            <label class="form-label">File Laporan <span class="text-danger">*</span></label>
                                                            <input type="file" name="file" required class="form-control" accept=".pdf,.doc,.docx">
                                                            <small class="text-muted">PDF/Word, max 10MB</small>
                                                        </div>
                                                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Unggah</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada periode laporan ditetapkan operator.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tab: Laporan Akhir --}}
        <div class="tab-pane fade" id="tabAkhir">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h6 class="mb-0">Laporan Akhir</h6></div>
                <div class="card-body">
                    @if ($proposal->laporanAkhir)
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1"><i class="ri-file-text-line me-1"></i> Laporan akhir telah diunggah pada <strong>{{ $proposal->laporanAkhir->tgl_unggah->format('d M Y') }}</strong></p>
                                @php
                                    $key = $proposal->laporanAkhir->status;
                                    [$label, $cls] = $statusLaporan[$key] ?? [$key, 'bg-light text-muted'];
                                @endphp
                                <span class="badge {{ $cls }}">{{ $label }}</span>
                                @if ($proposal->laporanAkhir->catatan_verifikator)
                                    <p class="text-muted small mt-2">Catatan: {{ $proposal->laporanAkhir->catatan_verifikator }}</p>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ asset('storage/' . $proposal->laporanAkhir->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i> Unduh</a>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#mAkhir"><i class="ri-upload-line"></i> Ganti File</button>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ri-file-text-line fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted">Belum ada laporan akhir.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mAkhir"><i class="ri-upload-line"></i> Unggah Laporan Akhir</button>
                        </div>
                    @endif

                    <div class="modal fade" id="mAkhir" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('dosen.laporan.akhir', $proposal) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header"><h6 class="modal-title">{{ $proposal->laporanAkhir ? 'Ganti' : 'Unggah' }} Laporan Akhir</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body text-start">
                                        <label class="form-label">File Laporan <span class="text-danger">*</span></label>
                                        <input type="file" name="file" required class="form-control" accept=".pdf,.doc,.docx">
                                        <small class="text-muted">PDF/Word, max 10MB</small>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Unggah</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab: Luaran --}}
        <div class="tab-pane fade" id="tabLuaran">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Luaran {{ $isPkm ? 'PKM' : 'Penelitian' }}</h6>
                    <small class="text-muted">Unggah luaran sesuai jenis yang dihasilkan.</small>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light"><tr><th>Jenis Luaran</th><th>Tanggal Unggah</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($jenisLuaranList as $jl)
                                @php $lr = $luaranByJenis[$jl->id] ?? null; @endphp
                                <tr>
                                    <td>
                                        <i class="ri-file-list-3-line text-primary me-2"></i>{{ $jl->nama }}
                                        @if ($lr?->link_url)
                                            <br><a href="{{ $lr->link_url }}" target="_blank" class="small text-truncate d-inline-block" style="max-width:300px;"><i class="ri-link"></i> {{ $lr->link_url }}</a>
                                        @endif
                                        @if ($lr?->keterangan)
                                            <br><small class="text-muted">{{ $lr->keterangan }}</small>
                                        @endif
                                    </td>
                                    <td class="small">{{ $lr?->tgl_unggah?->format('d M Y') ?? '-' }}</td>
                                    <td>
                                        @php
                                            $key = $lr?->status ?? 'belum_unggah';
                                            [$label, $cls] = $statusLaporan[$key] ?? [$key, 'bg-light text-muted'];
                                        @endphp
                                        <span class="badge {{ $cls }}">{{ $label }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            @if ($lr?->file_path)
                                                <a href="{{ asset('storage/' . $lr->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-download-line"></i></a>
                                            @endif
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mLuaran{{ $jl->id }}">
                                                <i class="ri-upload-line"></i> {{ $lr ? 'Update' : 'Unggah' }}
                                            </button>
                                        </div>

                                        <div class="modal fade" id="mLuaran{{ $jl->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('dosen.laporan.luaran', $proposal) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="jenis_luaran_id" value="{{ $jl->id }}">
                                                        <div class="modal-header"><h6 class="modal-title">Unggah {{ $jl->nama }}</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                        <div class="modal-body text-start">
                                                            <label class="form-label">File</label>
                                                            <input type="file" name="file" class="form-control">
                                                            <small class="text-muted">PDF/Word/Image/Video, max 10MB</small>
                                                            <hr>
                                                            <label class="form-label">Link / URL <span class="text-muted small">(opsional)</span></label>
                                                            <input type="url" name="link_url" class="form-control" placeholder="https://..." value="{{ $lr?->link_url }}">
                                                            <hr>
                                                            <label class="form-label">Keterangan</label>
                                                            <textarea name="keterangan" rows="2" class="form-control">{{ $lr?->keterangan }}</textarea>
                                                            <small class="text-muted">Salah satu dari File atau Link wajib diisi.</small>
                                                        </div>
                                                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Unggah</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada jenis luaran terdaftar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
