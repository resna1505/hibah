@extends('layouts.dosen')

@section('title', 'Detail Usulan Penelitian')

@php $activeNav = 'penelitian'; @endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detail Usulan Penelitian</h4>
            <p class="text-muted small mb-0">{{ $p->skemaHibah->nama }} &middot; {{ $p->periodeHibah->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
            @if (in_array($p->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                <a href="{{ route('dosen.penelitian.edit', $p) }}" class="btn btn-sm btn-warning"><i class="ri-edit-line"></i> Edit</a>
            @endif
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-download-line"></i> Unduh PDF
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Proposal</h6></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.pdf', $p) }}"><i class="ri-file-pdf-line me-1"></i> PDF Lengkap</a></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.pdf.identitas', $p) }}"><i class="ri-file-list-2-line me-1"></i> Identitas + Pengesahan</a></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.pdf.substansi', $p) }}"><i class="ri-file-text-line me-1"></i> Substansi (Pendahuluan, Metode, RAB)</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Lampiran Wajib</h6></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.pdf.biodata', $p) }}"><i class="ri-user-line me-1"></i> Biodata Ketua &amp; Anggota Tim</a></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.penelitian.pdf.pernyataan', $p) }}"><i class="ri-quill-pen-line me-1"></i> Surat Pernyataan Ketua</a></li>
                </ul>
            </div>
            @if (in_array($p->status, ['disetujui', 'berjalan', 'selesai']))
                <a href="{{ route('dosen.laporan.show', $p) }}" class="btn btn-sm btn-success"><i class="ri-file-list-3-line"></i> Kelola Laporan</a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="mb-0">{{ $p->judul }}</h5>
                <x-status-badge :status="$p->status" large />
            </div>
            @if ($p->no_registrasi)
                <p class="small mb-1">No. Registrasi: <code>{{ $p->no_registrasi }}</code></p>
            @endif
            <p class="text-muted small mb-3">
                Ketua: {{ $p->ketua->nama_lengkap }} &middot;
                {{ $p->ketua->fakultas?->nama }} &middot;
                Total Anggaran: <strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong> &middot;
                Durasi: {{ $p->durasi_bulan }} bulan
            </p>

            @if ($p->ringkasan)
                <h6>Ringkasan</h6>
                <p class="small">{{ $p->ringkasan }}</p>
            @endif

            @if ($p->kata_kunci)
                <p class="small"><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            @if ($p->pendahuluan)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Pendahuluan</h6></div>
                    <div class="card-body">
                        <p class="small text-justify" style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p>
                    </div>
                </div>
            @endif

            @if ($p->metode)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Metode</h6></div>
                    <div class="card-body">
                        <p class="small text-justify" style="white-space: pre-wrap;">{{ $p->metode }}</p>
                        @if ($p->metode_diagram_path)
                            <hr>
                            <p class="small fw-medium">Diagram alir:</p>
                            <img src="{{ asset('storage/' . $p->metode_diagram_path) }}" alt="diagram" class="img-fluid border rounded" style="max-height:400px;">
                        @endif
                    </div>
                </div>
            @endif

            @if ($p->jadwal_json && (! empty($p->jadwal_json['rows']) || ! empty($p->jadwal_json['text'])))
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Jadwal Penelitian</h6></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('dosen._shared.jadwal-display', ['p' => $p, 'variant' => 'show'])
                        </div>
                    </div>
                </div>
            @endif

            @if ($p->daftar_pustaka)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Daftar Pustaka</h6></div>
                    <div class="card-body"><p class="small" style="white-space: pre-wrap;">{{ $p->daftar_pustaka }}</p></div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0">Tim Pengusul</h6></div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Ketua:</strong><br>{{ $p->ketua->nama_lengkap }}</p>
                    @foreach ($p->anggota as $a)
                        <div class="border-top pt-2 mt-2 small">
                            @if ($a->peran === 'anggota_dosen')
                                <strong>Anggota Dosen:</strong><br>{{ $a->dosen?->nama_lengkap }}
                            @else
                                <strong>Mahasiswa:</strong><br>{{ $a->nama_mahasiswa }} ({{ $a->nim }})<br>
                                <span class="text-muted">{{ $a->program_studi }}</span>
                            @endif
                            @if ($a->bidang_tugas)
                                <br><span class="text-muted">{{ $a->bidang_tugas }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($p->bidangStrategis)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Bidang Strategis</h6></div>
                    <div class="card-body small">
                        <p class="mb-1"><strong>{{ $p->bidangStrategis->kode }}. {{ $p->bidangStrategis->nama }}</strong></p>
                        @if ($p->rumusan_masalah_bidang)
                            <p class="mb-1"><span class="text-muted">Rumusan Masalah:</span><br>{{ $p->rumusan_masalah_bidang }}</p>
                        @endif
                        @if ($p->uraian_bidang)
                            <p class="mb-0"><span class="text-muted">Uraian:</span><br>{{ $p->uraian_bidang }}</p>
                        @endif
                    </div>
                </div>
            @endif

            @if ($p->mitra->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Mitra Penelitian</h6></div>
                    <div class="card-body">
                        @foreach ($p->mitra as $m)
                            <div class="small mb-2 pb-2 border-bottom">
                                <strong>{{ $m->nama_mitra }}</strong>
                                @if ($m->pimpinan_mitra) <br><span class="text-muted">Pimpinan: {{ $m->pimpinan_mitra }}</span>@endif
                                @if ($m->alamat_mitra) <br><span class="text-muted">{{ $m->alamat_mitra }}</span>@endif
                                @if ($m->permasalahan_mitra) <br><em class="text-muted">{{ $m->permasalahan_mitra }}</em>@endif
                                @if ($m->dokumen_path) <br><a href="{{ asset('storage/' . $m->dokumen_path) }}" target="_blank"><i class="ri-file-pdf-line"></i> Dokumen Mitra</a>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-12">
            @if ($p->dokumen->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Dokumen Pendukung</h6></div>
                    <div class="card-body p-0">
                        <table class="table mb-0 small">
                            <thead class="table-light"><tr><th width="220">Jenis</th><th>Nama File</th><th width="120">Ukuran</th><th width="160">Tanggal</th></tr></thead>
                            <tbody>
                                @foreach ($p->dokumen as $d)
                                    <tr>
                                        <td><span class="badge bg-secondary-subtle text-dark">{{ $d->jenis }}</span></td>
                                        <td><a href="{{ asset('storage/' . $d->path) }}" target="_blank">{{ $d->nama_file }}</a></td>
                                        <td class="text-muted">{{ number_format($d->ukuran / 1024, 1) }} KB</td>
                                        <td class="text-muted">{{ $d->created_at->translatedFormat('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if ($p->rencanaLuaran->isNotEmpty())
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Rencana Luaran</h6></div>
                    <div class="card-body p-0">
                        <table class="table mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Tahun ke-</th>
                                    <th width="100">Kategori</th>
                                    <th>Jenis Luaran</th>
                                    <th>Status Target</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($p->rencanaLuaran as $rl)
                                    <tr>
                                        <td>{{ $rl->tahun_ke }}</td>
                                        <td>{{ ucfirst($rl->kategori) }}</td>
                                        <td>{{ $rl->jenisLuaran?->nama ?? $rl->jenis_luaran_text ?? '-' }}</td>
                                        <td>{{ $rl->status_target ?? '-' }}</td>
                                        <td class="text-muted">{{ $rl->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0">Rencana Anggaran Biaya</h6>
                    <strong class="text-primary">Total: Rp {{ number_format($totalRab, 0, ',', '.') }}</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 small">
                        <thead class="table-light">
                            <tr><th>Kelompok</th><th>Komponen</th><th>Item</th><th>Justifikasi</th><th class="text-end">Kuantitas</th><th class="text-end">Harga Satuan</th><th class="text-end">Sub Total</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($p->rab as $r)
                                <tr>
                                    <td>{{ $r->kategori?->nama }}</td>
                                    <td class="text-muted"><em>{{ $r->komponen?->nama ?? '-' }}</em></td>
                                    <td>{{ $r->item }}</td>
                                    <td class="text-muted">{{ $r->justifikasi }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }} {{ $r->satuan }}</td>
                                    <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-3">RAB belum diisi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
