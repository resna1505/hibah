<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeHibah extends Model
{
    protected $table = 'periode_hibah_t';

    protected $fillable = ['tahun', 'nama', 'status', 'keterangan'];

    protected $casts = [
        'tahun' => 'integer',
    ];

    public function jadwalTahapan(): HasMany
    {
        return $this->hasMany(JadwalTahapan::class, 'periode_hibah_id');
    }

    public function periodeLaporan(): HasMany
    {
        return $this->hasMany(PeriodeLaporan::class, 'periode_hibah_id');
    }

    public function proposal(): HasMany
    {
        return $this->hasMany(Proposal::class, 'periode_hibah_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
