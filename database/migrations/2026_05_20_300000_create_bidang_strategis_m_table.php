<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bidang_strategis_m', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('kode')->comment('1-8 sesuai prioritas riset nasional');
            $table->string('nama', 200);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang_strategis_m');
    }
};
