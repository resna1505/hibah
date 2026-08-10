<?php

namespace App\Models\Transaction;

use App\Models\Master\TahapanHibah;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class JadwalTahapan extends Model
{
    /**
     * Zona waktu yang dipakai pengguna (LPPM Universitas Batam).
     * Aplikasi menyimpan waktu dalam config('app.timezone') (UTC), sedangkan
     * operator memasukkan dan membaca jadwal dalam WIB — konversinya terpusat di sini.
     */
    public const TZ_LOKAL = 'Asia/Jakarta';

    protected $table = 'jadwal_tahapan_t';

    protected $fillable = [
        'periode_hibah_id',
        'tahapan_hibah_id',
        'tgl_mulai',
        'tgl_selesai',
        'batas_submit',
        'status',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'batas_submit' => 'datetime',
    ];

    /**
     * Batas submit efektif dalam WIB. Bila operator belum mengisi batas eksplisit,
     * jatuh kembali ke akhir hari `tgl_selesai` (23:59:59 WIB).
     */
    public function batasSubmitEfektif(): ?CarbonInterface
    {
        if ($this->batas_submit) {
            return $this->batas_submit->copy()->setTimezone(self::TZ_LOKAL);
        }

        if ($this->tgl_selesai) {
            return Carbon::parse($this->tgl_selesai->toDateString() . ' 23:59:59', self::TZ_LOKAL);
        }

        return null;
    }

    /**
     * Ubah input operator (`datetime-local`, dibaca sebagai WIB) menjadi waktu
     * simpan aplikasi. Tanpa ini batas "23:59 WIB" akan tersimpan sebagai 23:59 UTC
     * dan sistem menutup submit pada 06:59 WIB keesokan harinya.
     */
    public static function parseBatasSubmit(?string $input): ?CarbonInterface
    {
        if (! $input) {
            return null;
        }

        return Carbon::parse($input, self::TZ_LOKAL)->setTimezone(config('app.timezone'));
    }

    public function periodeHibah(): BelongsTo
    {
        return $this->belongsTo(PeriodeHibah::class, 'periode_hibah_id');
    }

    public function tahapanHibah(): BelongsTo
    {
        return $this->belongsTo(TahapanHibah::class, 'tahapan_hibah_id');
    }
}
