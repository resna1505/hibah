<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_anggota_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('dosen_m')->nullOnDelete();
            $table->string('nama_mahasiswa', 200)->nullable();
            $table->string('nim', 30)->nullable();
            $table->string('program_studi', 150)->nullable();
            $table->enum('peran', ['anggota_dosen', 'mahasiswa']);
            $table->string('bidang_tugas', 300)->nullable();
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_anggota_t');
    }
};
