<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen_keahlian_m', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen_m')->cascadeOnDelete();
            $table->foreignId('keahlian_id')->constrained('keahlian_m')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['dosen_id', 'keahlian_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_keahlian_m');
    }
};
