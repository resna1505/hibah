<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class BidangStrategis extends Model
{
    protected $table = 'bidang_strategis_m';

    protected $fillable = ['kode', 'nama', 'deskripsi', 'is_active'];

    protected $casts = [
        'kode' => 'integer',
        'is_active' => 'boolean',
    ];
}
