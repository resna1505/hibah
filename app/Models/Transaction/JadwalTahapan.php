<?php

namespace App\Models\Transaction;

use App\Models\Master\TahapanHibah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalTahapan extends Model
{
    protected $table = 'jadwal_tahapan_t';

    protected $fillable = [
        'periode_hibah_id',
        'tahapan_hibah_id',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function periodeHibah(): BelongsTo
    {
        return $this->belongsTo(PeriodeHibah::class, 'periode_hibah_id');
    }

    public function tahapanHibah(): BelongsTo
    {
        return $this->belongsTo(TahapanHibah::class, 'tahapan_hibah_id');
    }
}
