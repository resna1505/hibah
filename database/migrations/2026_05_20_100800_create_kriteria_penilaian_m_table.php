<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria_penilaian_m', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_hibah_id')->constrained('skema_hibah_m')->cascadeOnDelete();
            $table->unsignedTinyInteger('urutan');
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('bobot_persen')->comment('Total per skema harus 100');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['skema_hibah_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaian_m');
    }
};
