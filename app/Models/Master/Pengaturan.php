<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    protected $table = 'pengaturan_m';

    protected $fillable = ['kunci', 'nilai', 'grup', 'label', 'tipe'];

    public static function get(string $kunci, $default = null)
    {
        $cache = Cache::remember('pengaturan_all', 300, function () {
            return static::pluck('nilai', 'kunci')->toArray();
        });
        return $cache[$kunci] ?? $default;
    }

    public static function set(string $kunci, $nilai): void
    {
        static::where('kunci', $kunci)->update(['nilai' => $nilai]);
        Cache::forget('pengaturan_all');
    }

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget('pengaturan_all'));
        static::deleted(fn() => Cache::forget('pengaturan_all'));
    }
}
