<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_dokumen_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->string('jenis', 100)->comment('Misal: surat_pernyataan, biodata, rab_excel');
            $table->string('nama_file', 255);
            $table->string('path');
            $table->unsignedInteger('ukuran')->default(0)->comment('Bytes');
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_dokumen_t');
    }
};
