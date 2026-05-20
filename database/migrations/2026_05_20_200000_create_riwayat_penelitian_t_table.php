<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_penelitian_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen_m')->cascadeOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->string('judul', 500);
            $table->string('sumber_pendanaan', 150)->nullable();
            $table->string('skema_penelitian', 100)->nullable();
            $table->enum('peran', ['ketua', 'anggota']);
            $table->enum('status', ['selesai', 'berjalan']);
            $table->string('luaran', 300)->nullable();
            $table->timestamps();

            $table->index(['dosen_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_penelitian_t');
    }
};
