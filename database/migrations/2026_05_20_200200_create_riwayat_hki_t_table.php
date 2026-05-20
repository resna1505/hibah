<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_hki_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen_m')->cascadeOnDelete();
            $table->enum('jenis_hki', [
                'Hak Cipta',
                'Paten',
                'Merek',
                'Desain Industri',
                'Rahasia Dagang',
                'Lainnya',
            ]);
            $table->string('judul', 500);
            $table->string('no_pendaftaran', 100)->nullable();
            $table->string('no_sertifikat', 100)->nullable();
            $table->unsignedSmallInteger('tahun_pengajuan')->nullable();
            $table->unsignedSmallInteger('tahun_terbit')->nullable();
            $table->enum('status_hki', ['Terdaftar', 'Proses', 'Granted'])->default('Proses');
            $table->enum('peran', ['ketua', 'anggota']);
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->index('dosen_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_hki_t');
    }
};
