<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_detail_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaian_t')->cascadeOnDelete();
            $table->foreignId('kriteria_id')->constrained('kriteria_penilaian_m');
            $table->unsignedTinyInteger('skor')->comment('Skala 1-5');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['penilaian_id', 'kriteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_detail_t');
    }
};
