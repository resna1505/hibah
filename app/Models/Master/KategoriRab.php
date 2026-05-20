<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriRab extends Model
{
    protected $table = 'kategori_rab_m';

    protected $fillable = ['kode', 'nama', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function komponen(): HasMany
    {
        return $this->hasMany(KomponenRab::class, 'kategori_rab_id')->orderBy('urutan');
    }
}
