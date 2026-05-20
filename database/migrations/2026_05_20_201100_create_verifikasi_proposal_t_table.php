<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_proposal_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('operator_id')->constrained('users_m');
            $table->enum('status', ['lengkap', 'dikembalikan', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamp('tgl_verifikasi')->useCurrent();
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_proposal_t');
    }
};
