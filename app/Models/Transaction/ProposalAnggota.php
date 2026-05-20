<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalAnggota extends Model
{
    protected $table = 'proposal_anggota_t';

    protected $fillable = [
        'proposal_id',
        'dosen_id',
        'nama_mahasiswa',
        'nim',
        'program_studi',
        'peran',
        'bidang_tugas',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
