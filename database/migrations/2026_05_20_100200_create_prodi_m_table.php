<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prodi_m', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->constrained('fakultas_m')->cascadeOnDelete();
            $table->string('kode', 20)->unique();
            $table->string('nama', 150);
            $table->enum('jenjang', ['D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'])->default('S1');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi_m');
    }
};
