<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatHki extends Model
{
    protected $table = 'riwayat_hki_t';

    protected $fillable = [
        'dosen_id',
        'jenis_hki',
        'judul',
        'no_pendaftaran',
        'no_sertifikat',
        'tahun_pengajuan',
        'tahun_terbit',
        'status_hki',
        'peran',
        'file_path',
    ];

    protected $casts = [
        'tahun_pengajuan' => 'integer',
        'tahun_terbit' => 'integer',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
