<?php

namespace App\Models\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi_t';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'link',
        'icon',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeBelumDibaca($query)
    {
        return $query->whereNull('dibaca_at');
    }

    public function markRead(): void
    {
        if (! $this->dibaca_at) {
            $this->dibaca_at = now();
            $this->save();
        }
    }
}
