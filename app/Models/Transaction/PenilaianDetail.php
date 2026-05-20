<?php

namespace App\Models\Transaction;

use App\Models\Master\KriteriaPenilaian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianDetail extends Model
{
    protected $table = 'penilaian_detail_t';

    protected $fillable = [
        'penilaian_id',
        'kriteria_id',
        'skor',
        'catatan',
    ];

    protected $casts = [
        'skor' => 'integer',
    ];

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }
}
