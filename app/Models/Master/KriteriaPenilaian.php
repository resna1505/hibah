<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaPenilaian extends Model
{
    protected $table = 'kriteria_penilaian_m';

    protected $fillable = [
        'skema_hibah_id',
        'urutan',
        'nama',
        'deskripsi',
        'bobot_persen',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bobot_persen' => 'integer',
    ];

    public function skemaHibah(): BelongsTo
    {
        return $this->belongsTo(SkemaHibah::class, 'skema_hibah_id');
    }
}
