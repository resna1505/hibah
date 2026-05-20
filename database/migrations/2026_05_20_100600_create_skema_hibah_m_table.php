<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skema_hibah_m', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->enum('jenis', ['penelitian', 'pkm']);
            $table->string('nama', 200);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('max_anggaran')->default(0);
            $table->unsignedTinyInteger('max_durasi_bulan')->default(12);
            $table->unsignedTinyInteger('max_anggota_dosen')->default(2);
            $table->unsignedTinyInteger('max_anggota_mahasiswa')->default(2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skema_hibah_m');
    }
};
