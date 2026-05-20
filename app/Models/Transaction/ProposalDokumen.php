<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalDokumen extends Model
{
    protected $table = 'proposal_dokumen_t';

    protected $fillable = [
        'proposal_id',
        'jenis',
        'nama_file',
        'path',
        'ukuran',
    ];

    protected $casts = [
        'ukuran' => 'integer',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
