<?php

namespace App\Models\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiProposal extends Model
{
    protected $table = 'verifikasi_proposal_t';

    protected $fillable = [
        'proposal_id',
        'operator_id',
        'status',
        'catatan',
        'tgl_verifikasi',
    ];

    protected $casts = [
        'tgl_verifikasi' => 'datetime',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
