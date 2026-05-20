<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_laporan_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_hibah_id')->constrained('periode_hibah_t')->cascadeOnDelete();
            $table->enum('skema_jenis', ['penelitian', 'pkm']);
            $table->unsignedTinyInteger('urutan')->comment('1, 2, dst');
            $table->string('label', 100)->comment('Misal: Kemajuan 50%');
            $table->date('batas_unggah');
            $table->timestamps();

            $table->index(['periode_hibah_id', 'skema_jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_laporan_t');
    }
};
