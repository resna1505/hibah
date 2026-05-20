<?php

namespace App\Models\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKemajuan extends Model
{
    protected $table = 'laporan_kemajuan_t';

    protected $fillable = [
        'proposal_id',
        'periode_laporan_id',
        'file_path',
        'tgl_unggah',
        'status',
        'verifikator_id',
        'catatan_verifikator',
    ];

    protected $casts = [
        'tgl_unggah' => 'datetime',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function periodeLaporan(): BelongsTo
    {
        return $this->belongsTo(PeriodeLaporan::class, 'periode_laporan_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}
