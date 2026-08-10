<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Batas waktu submit proposal yang bisa diatur operator.
 *
 * Sebelumnya penutupan tahapan hanya bergantung pada kolom enum `status` yang
 * diubah manual, sementara `tgl_selesai` bertipe DATE sehingga tidak bisa
 * menyatakan batas berjam ("23:59"). Kolom ini menyimpan batas presisi menit.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_tahapan_t', function (Blueprint $table) {
            $table->dateTime('batas_submit')->nullable()->after('tgl_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_tahapan_t', function (Blueprint $table) {
            $table->dropColumn('batas_submit');
        });
    }
};
