<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPenelitian extends Model
{
    protected $table = 'riwayat_penelitian_t';

    protected $fillable = [
        'dosen_id',
        'tahun',
        'judul',
        'sumber_pendanaan',
        'skema_penelitian',
        'peran',
        'status',
        'luaran',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
