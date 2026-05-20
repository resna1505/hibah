<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevisiProposal extends Model
{
    protected $table = 'revisi_proposal_t';

    protected $fillable = [
        'proposal_id',
        'file_path',
        'catatan_dosen',
        'tgl_revisi',
    ];

    protected $casts = [
        'tgl_revisi' => 'datetime',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
