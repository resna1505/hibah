<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahapan_hibah_m', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('urutan');
            $table->string('kode', 30)->unique();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->string('icon', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan_hibah_m');
    }
};
