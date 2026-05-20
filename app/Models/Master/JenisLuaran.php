<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class JenisLuaran extends Model
{
    protected $table = 'jenis_luaran_m';

    protected $fillable = ['skema_jenis', 'kode', 'nama', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopePenelitian($query)
    {
        return $query->where('skema_jenis', 'penelitian');
    }

    public function scopePkm($query)
    {
        return $query->where('skema_jenis', 'pkm');
    }
}
