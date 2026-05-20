<?php

namespace App\Models\Transaction;

use App\Models\Master\Dosen;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PenugasanReviewer extends Model
{
    protected $table = 'penugasan_reviewer_t';

    protected $fillable = [
        'proposal_id',
        'reviewer_dosen_id',
        'peran',
        'deadline',
        'status',
        'ditugaskan_oleh',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'reviewer_dosen_id');
    }

    public function ditugaskanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditugaskan_oleh');
    }

    public function penilaian(): HasOne
    {
        return $this->hasOne(Penilaian::class, 'penugasan_id');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', '!=', 'selesai')
            ->where('deadline', '<', now()->toDateString());
    }
}
