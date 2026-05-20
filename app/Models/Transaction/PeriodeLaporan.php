<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodeLaporan extends Model
{
    protected $table = 'periode_laporan_t';

    protected $fillable = [
        'periode_hibah_id',
        'skema_jenis',
        'urutan',
        'label',
        'batas_unggah',
    ];

    protected $casts = [
        'batas_unggah' => 'date',
    ];

    public function periodeHibah(): BelongsTo
    {
        return $this->belongsTo(PeriodeHibah::class, 'periode_hibah_id');
    }
}
