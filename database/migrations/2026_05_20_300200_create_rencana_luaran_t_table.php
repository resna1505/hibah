<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rencana_luaran_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->unsignedTinyInteger('tahun_ke')->default(1)->comment('1, 2, 3, dst');
            $table->enum('kategori', ['wajib', 'tambahan'])->default('wajib');
            $table->foreignId('jenis_luaran_id')->nullable()->constrained('jenis_luaran_m')->nullOnDelete();
            $table->string('jenis_luaran_text', 200)->nullable()->comment('Bila tidak terdaftar di master');
            $table->string('status_target', 100)->nullable()->comment('Submitted/Accepted/Published/Granted/dll');
            $table->text('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['proposal_id', 'tahun_ke']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_luaran_t');
    }
};
