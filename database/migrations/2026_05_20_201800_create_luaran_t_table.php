<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('luaran_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('jenis_luaran_id')->constrained('jenis_luaran_m');
            $table->string('file_path')->nullable();
            $table->string('link_url', 500)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('tgl_unggah')->useCurrent();
            $table->enum('status', ['belum_unggah', 'menunggu', 'terverifikasi', 'ditolak'])->default('belum_unggah');
            $table->foreignId('verifikator_id')->nullable()->constrained('users_m')->nullOnDelete();
            $table->text('catatan_verifikator')->nullable();
            $table->timestamps();

            $table->unique(['proposal_id', 'jenis_luaran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('luaran_t');
    }
};
