<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prodi extends Model
{
    protected $table = 'prodi_m';

    protected $fillable = ['fakultas_id', 'kode', 'nama', 'jenjang', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}
