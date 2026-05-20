<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen_m', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users_m')->cascadeOnDelete();
            $table->foreignId('fakultas_id')->constrained('fakultas_m');
            $table->foreignId('prodi_id')->constrained('prodi_m');

            $table->string('nama_lengkap', 200);
            $table->string('nidn', 20)->nullable()->unique();
            $table->string('nidk', 20)->nullable()->unique();

            $table->enum('jabatan_fungsional', [
                'Tenaga Pengajar',
                'Asisten Ahli',
                'Lektor',
                'Lektor Kepala',
                'Profesor',
            ])->nullable();
            $table->string('pangkat_golongan', 30)->nullable();
            $table->enum('pendidikan_terakhir', ['S1', 'S2', 'S3'])->nullable();

            $table->string('no_hp', 25)->nullable();
            $table->string('foto_path')->nullable();

            $table->string('scopus_id', 50)->nullable();
            $table->string('google_scholar_id', 100)->nullable();
            $table->string('sinta_id', 50)->nullable();
            $table->unsignedInteger('sinta_score')->default(0);

            $table->boolean('status_aktif_mengajar')->default(true);
            $table->boolean('is_reviewer')->default(false);

            $table->timestamps();

            $table->index('is_reviewer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_m');
    }
};
