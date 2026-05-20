<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revisi_proposal_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->string('file_path');
            $table->text('catatan_dosen')->nullable();
            $table->timestamp('tgl_revisi')->useCurrent();
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisi_proposal_t');
    }
};
