<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkemaHibah extends Model
{
    protected $table = 'skema_hibah_m';

    protected $fillable = [
        'kode',
        'jenis',
        'nama',
        'deskripsi',
        'max_anggaran',
        'max_durasi_bulan',
        'max_anggota_dosen',
        'max_anggota_mahasiswa',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_anggaran' => 'integer',
    ];

    public function kriteriaPenilaian(): HasMany
    {
        return $this->hasMany(KriteriaPenilaian::class, 'skema_hibah_id')->orderBy('urutan');
    }
}
