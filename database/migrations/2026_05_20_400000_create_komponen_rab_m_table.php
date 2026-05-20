<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_rab_m', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_rab_id')->constrained('kategori_rab_m')->cascadeOnDelete();
            $table->string('kode', 40);
            $table->string('nama', 200);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['kategori_rab_id', 'kode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen_rab_m');
    }
};
