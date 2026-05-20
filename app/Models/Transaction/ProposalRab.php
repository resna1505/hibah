<?php

namespace App\Models\Transaction;

use App\Models\Master\KategoriRab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalRab extends Model
{
    protected $table = 'proposal_rab_t';

    protected $fillable = [
        'proposal_id',
        'kategori_rab_id',
        'item',
        'justifikasi',
        'kuantitas',
        'satuan',
        'harga_satuan',
        'sub_total',
    ];

    protected $casts = [
        'kuantitas' => 'decimal:2',
        'harga_satuan' => 'integer',
        'sub_total' => 'integer',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriRab::class, 'kategori_rab_id');
    }
}
