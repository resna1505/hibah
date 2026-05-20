<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use App\Models\Master\SkemaHibah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    protected $table = 'proposal_t';

    protected $fillable = [
        'periode_hibah_id',
        'skema_hibah_id',
        'ketua_dosen_id',
        'judul',
        'ringkasan',
        'kata_kunci',
        'pendahuluan',
        'metode',
        'metode_diagram_path',
        'hasil_diharapkan_json',
        'jadwal_json',
        'daftar_pustaka',
        'permasalahan_solusi',
        'total_anggaran',
        'durasi_bulan',
        'status',
        'pernyataan_setuju',
        'tgl_submit',
    ];

    protected $casts = [
        'hasil_diharapkan_json' => 'array',
        'jadwal_json' => 'array',
        'pernyataan_setuju' => 'boolean',
        'tgl_submit' => 'datetime',
        'total_anggaran' => 'integer',
        'durasi_bulan' => 'integer',
    ];

    public function periodeHibah(): BelongsTo
    {
        return $this->belongsTo(PeriodeHibah::class, 'periode_hibah_id');
    }

    public function skemaHibah(): BelongsTo
    {
        return $this->belongsTo(SkemaHibah::class, 'skema_hibah_id');
    }

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'ketua_dosen_id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(ProposalAnggota::class, 'proposal_id');
    }

    public function mitra(): HasMany
    {
        return $this->hasMany(ProposalMitra::class, 'proposal_id');
    }

    public function rab(): HasMany
    {
        return $this->hasMany(ProposalRab::class, 'proposal_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(ProposalDokumen::class, 'proposal_id');
    }

    public function verifikasi(): HasMany
    {
        return $this->hasMany(VerifikasiProposal::class, 'proposal_id');
    }

    public function penugasanReviewer(): HasMany
    {
        return $this->hasMany(PenugasanReviewer::class, 'proposal_id');
    }

    public function revisi(): HasMany
    {
        return $this->hasMany(RevisiProposal::class, 'proposal_id');
    }

    public function laporanKemajuan(): HasMany
    {
        return $this->hasMany(LaporanKemajuan::class, 'proposal_id');
    }

    public function laporanAkhir(): HasOne
    {
        return $this->hasOne(LaporanAkhir::class, 'proposal_id');
    }

    public function luaran(): HasMany
    {
        return $this->hasMany(Luaran::class, 'proposal_id');
    }
}
