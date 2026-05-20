<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_luaran_m', function (Blueprint $table) {
            $table->id();
            $table->enum('skema_jenis', ['penelitian', 'pkm']);
            $table->string('kode', 30)->unique();
            $table->string('nama', 150);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('skema_jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_luaran_m');
    }
};
