<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPkm extends Model
{
    protected $table = 'riwayat_pkm_t';

    protected $fillable = [
        'dosen_id',
        'tahun',
        'judul',
        'skema_pkm',
        'sumber_dana',
        'peran',
        'lokasi',
        'mitra',
        'luaran',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
