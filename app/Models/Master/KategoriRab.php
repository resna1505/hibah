<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KategoriRab extends Model
{
    protected $table = 'kategori_rab_m';

    protected $fillable = ['kode', 'nama', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
