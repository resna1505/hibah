<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pkm_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen_m')->cascadeOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->string('judul', 500);
            $table->string('skema_pkm', 100)->nullable();
            $table->string('sumber_dana', 150)->nullable();
            $table->enum('peran', ['ketua', 'anggota']);
            $table->string('lokasi', 200)->nullable();
            $table->string('mitra', 200)->nullable();
            $table->string('luaran', 300)->nullable();
            $table->enum('status', ['selesai', 'berjalan']);
            $table->timestamps();

            $table->index(['dosen_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pkm_t');
    }
};
