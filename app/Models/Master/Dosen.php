<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'scopus_id',
        'google_scholar_id',
        'sinta_id',
        'sinta_score',
        'status_aktif_mengajar',
        'is_reviewer',
    ];

    protected $casts = [
        'status_aktif_mengajar' => 'boolean',
        'is_reviewer' => 'boolean',
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
}
