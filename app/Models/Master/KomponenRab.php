<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomponenRab extends Model
{
    protected $table = 'komponen_rab_m';

    protected $fillable = ['kategori_rab_id', 'kode', 'nama', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriRab::class, 'kategori_rab_id');
    }
}
