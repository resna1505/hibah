<?php

namespace App\Models\Transaction;

use App\Models\Master\JenisLuaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RencanaLuaran extends Model
{
    protected $table = 'rencana_luaran_t';

    protected $fillable = [
        'proposal_id',
        'tahun_ke',
        'kategori',
        'jenis_luaran_id',
        'jenis_luaran_text',
        'status_target',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'tahun_ke' => 'integer',
        'urutan'   => 'integer',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function jenisLuaran(): BelongsTo
    {
        return $this->belongsTo(JenisLuaran::class, 'jenis_luaran_id');
    }
}
