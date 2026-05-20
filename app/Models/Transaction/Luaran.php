<?php

namespace App\Models\Transaction;

use App\Models\Master\JenisLuaran;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Luaran extends Model
{
    protected $table = 'luaran_t';

    protected $fillable = [
        'proposal_id',
        'jenis_luaran_id',
        'file_path',
        'link_url',
        'keterangan',
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

    public function jenisLuaran(): BelongsTo
    {
        return $this->belongsTo(JenisLuaran::class, 'jenis_luaran_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}
