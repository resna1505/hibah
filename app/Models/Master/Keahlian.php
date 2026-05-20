<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Keahlian extends Model
{
    protected $table = 'keahlian_m';

    protected $fillable = ['nama', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function dosen(): BelongsToMany
    {
        return $this->belongsToMany(Dosen::class, 'dosen_keahlian_m', 'keahlian_id', 'dosen_id')
            ->withTimestamps();
    }
}
