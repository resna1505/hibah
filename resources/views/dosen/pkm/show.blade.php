@extends('layouts.dosen')

@section('title', 'Detail Usulan PKM')

@php
    $activeNav = 'pengabdian';

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
    ];
    [$label, $cls] = $statusBadge[$p->status] ?? [$p->status, 'bg-light text-muted'];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Detail Usulan PKM</h4>
            <p class="text-muted small mb-0">{{ $p->skemaHibah->nama }} &middot; {{ $p->periodeHibah->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dosen.pkm.index') }}" class="btn btn-sm btn-outline-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
            @if (in_array($p->status, ['draft', 'dikembalikan', 'revisi_minor', 'revisi_mayor']))
                <a href="{{ route('dosen.pkm.edit', $p) }}" class="btn btn-sm btn-warning"><i class="ri-edit-line"></i> Edit</a>
            @endif
            <a href="{{ route('dosen.pkm.pdf', $p) }}" class="btn btn-sm btn-primary"><i class="ri-download-line"></i> Unduh PDF</a>
            @if (in_array($p->status, ['disetujui', 'berjalan', 'selesai']))
                <a href="{{ route('dosen.laporan.show', $p) }}" class="btn btn-sm btn-success"><i class="ri-file-list-3-line"></i> Kelola Laporan</a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="mb-0">{{ $p->judul }}</h5>
                <span class="badge {{ $cls }} fs-6">{{ $label }}</span>
            </div>
            <p class="text-muted small mb-3">
                Ketua: {{ $p->ketua->nama_lengkap }} &middot;
                Total Anggaran: <strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong> &middot;
                Durasi: {{ $p->durasi_bulan }} bulan
            </p>
            @if ($p->ringkasan)<h6>Ringkasan</h6><p class="small">{{ $p->ringkasan }}</p>@endif
            @if ($p->kata_kunci)<p class="small"><strong>Kata Kunci:</strong> {{ $p->kata_kunci }}</p>@endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            @if ($p->pendahuluan)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Pendahuluan</h6></div>
                    <div class="card-body"><p class="small" style="white-space: pre-wrap;">{{ $p->pendahuluan }}</p></div>
                </div>
            @endif

            @if ($p->permasalahan_solusi)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Permasalahan & Solusi</h6></div>
                    <div class="card-body"><p class="small" style="white-space: pre-wrap;">{{ $p->permasalahan_solusi }}</p></div>
                </div>
            @endif

            @if ($p->metode)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Metode Pelaksanaan</h6></div>
                    <div class="card-body">
                        <p class="small" style="white-space: pre-wrap;">{{ $p->metode }}</p>
                        @if ($p->metode_diagram_path)
                            <hr><img src="{{ asset('storage/' . $p->metode_diagram_path) }}" class="img-fluid border rounded" style="max-height:400px;">
                        @endif
                    </div>
                </div>
            @endif

            @if ($p->jadwal_json && ! empty($p->jadwal_json['text']))
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white"><h6 class="mb-0">Jadwal PKM</h6></div>
                    <div class="card-body"><p class="small" style="white-space: pre-wrap;">{{ $p->jadwal_json['text'] }}</p></div>
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
                            @if ($a->bidang_tugas)<br><span class="text-muted">{{ $a->bidang_tugas }}</span>@endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><h6 class="mb-0">Mitra Kerjasama</h6></div>
                <div class="card-body">
                    @forelse ($p->mitra as $m)
                        <div class="small mb-2 pb-2 border-bottom">
                            <strong>{{ $m->nama_mitra }}</strong><br>
                            @if ($m->pimpinan_mitra)<span class="text-muted">Pimpinan: {{ $m->pimpinan_mitra }}</span><br>@endif
                            @if ($m->alamat_mitra)<span class="text-muted small">{{ $m->alamat_mitra }}</span>@endif
                            @if ($m->permasalahan_mitra)<p class="mt-1 mb-0 small">{{ $m->permasalahan_mitra }}</p>@endif
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Belum ada mitra.</p>
                    @endforelse
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
        </div>

        <div class="col-12">
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

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0">RAB</h6>
                    <strong class="text-primary">Total: Rp {{ number_format($totalRab, 0, ',', '.') }}</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 small">
                        <thead class="table-light"><tr><th>Kategori</th><th>Item</th><th>Justifikasi</th><th class="text-end">Kuantitas</th><th class="text-end">Harga</th><th class="text-end">Sub Total</th></tr></thead>
                        <tbody>
                            @forelse ($p->rab as $r)
                                <tr>
                                    <td>{{ $r->kategori?->nama }}</td>
                                    <td>{{ $r->item }}</td>
                                    <td class="text-muted">{{ $r->justifikasi }}</td>
                                    <td class="text-end">{{ rtrim(rtrim(number_format($r->kuantitas, 2, ',', '.'), '0'), ',') }} {{ $r->satuan }}</td>
                                    <td class="text-end">Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($r->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">RAB belum diisi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
