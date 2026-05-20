<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalMitra extends Model
{
    protected $table = 'proposal_mitra_t';

    protected $fillable = [
        'proposal_id',
        'nama_mitra',
        'pimpinan_mitra',
        'alamat_mitra',
        'permasalahan_mitra',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
