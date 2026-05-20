<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kemajuan_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('periode_laporan_id')->constrained('periode_laporan_t');
            $table->string('file_path');
            $table->timestamp('tgl_unggah')->useCurrent();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->foreignId('verifikator_id')->nullable()->constrained('users_m')->nullOnDelete();
            $table->text('catatan_verifikator')->nullable();
            $table->timestamps();

            $table->unique(['proposal_id', 'periode_laporan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kemajuan_t');
    }
};
