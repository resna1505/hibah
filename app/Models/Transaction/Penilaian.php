<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian extends Model
{
    protected $table = 'penilaian_t';

    protected $fillable = [
        'penugasan_id',
        'nilai_total',
        'rekomendasi',
        'catatan_umum',
        'tgl_selesai',
    ];

    protected $casts = [
        'nilai_total' => 'decimal:2',
        'tgl_selesai' => 'datetime',
    ];

    public function penugasan(): BelongsTo
    {
        return $this->belongsTo(PenugasanReviewer::class, 'penugasan_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(PenilaianDetail::class, 'penilaian_id');
    }
}
