<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $table = 'fakultas_m';

    protected $fillable = ['kode', 'nama', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function prodi(): HasMany
    {
        return $this->hasMany(Prodi::class, 'fakultas_id');
    }
}
