<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_tahapan_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_hibah_id')->constrained('periode_hibah_t')->cascadeOnDelete();
            $table->foreignId('tahapan_hibah_id')->constrained('tahapan_hibah_m');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->enum('status', ['belum_mulai', 'berjalan', 'selesai'])->default('belum_mulai');
            $table->timestamps();

            $table->unique(['periode_hibah_id', 'tahapan_hibah_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_tahapan_t');
    }
};
