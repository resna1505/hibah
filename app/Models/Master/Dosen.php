<?php

namespace App\Models\Master;

use App\Models\Transaction\PenugasanReviewer;
use App\Models\Transaction\Proposal;
use App\Models\Transaction\RiwayatHki;
use App\Models\Transaction\RiwayatPenelitian;
use App\Models\Transaction\RiwayatPkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $table = 'dosen_m';

    protected $fillable = [
        'user_id',
        'fakultas_id',
        'prodi_id',
        'nama_lengkap',
        'nidn',
        'nidk',
        'jabatan_fungsional',
        'pangkat_golongan',
        'pendidikan_terakhir',
        'no_hp',
        'foto_path',
        'ttd_path',
        'scopus_id',
        'google_scholar_id',
        'sinta_id',
        'sinta_score',
        'status_aktif_mengajar',
        'is_reviewer',
        'is_ketua_eligible',
    ];

    protected $casts = [
        'status_aktif_mengajar' => 'boolean',
        'is_reviewer' => 'boolean',
        'is_ketua_eligible' => 'boolean',
        'sinta_score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function keahlian(): BelongsToMany
    {
        return $this->belongsToMany(Keahlian::class, 'dosen_keahlian_m', 'dosen_id', 'keahlian_id')
            ->withTimestamps();
    }

    public function riwayatPenelitian(): HasMany
    {
        return $this->hasMany(RiwayatPenelitian::class, 'dosen_id');
    }

    public function riwayatPkm(): HasMany
    {
        return $this->hasMany(RiwayatPkm::class, 'dosen_id');
    }

    public function riwayatHki(): HasMany
    {
        return $this->hasMany(RiwayatHki::class, 'dosen_id');
    }

    public function proposalSebagaiKetua(): HasMany
    {
        return $this->hasMany(Proposal::class, 'ketua_dosen_id');
    }

    public function penugasanReview(): HasMany
    {
        return $this->hasMany(PenugasanReviewer::class, 'reviewer_dosen_id');
    }
}
