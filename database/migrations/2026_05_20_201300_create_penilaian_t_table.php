<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->unique()->constrained('penugasan_reviewer_t')->cascadeOnDelete();
            $table->decimal('nilai_total', 5, 2)->default(0)->comment('Hasil sum(skor * bobot/100 * 20) max 100');
            $table->enum('rekomendasi', ['disetujui', 'revisi_minor', 'revisi_mayor', 'ditolak']);
            $table->text('catatan_umum')->comment('Catatan untuk Peneliti, wajib');
            $table->timestamp('tgl_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_t');
    }
};
