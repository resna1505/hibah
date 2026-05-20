<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_reviewer_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('reviewer_dosen_id')->constrained('dosen_m');
            $table->enum('peran', ['reviewer_1', 'reviewer_2', 'reviewer_3']);
            $table->date('deadline');
            $table->enum('status', ['ditugaskan', 'sedang_review', 'selesai', 'terlambat'])->default('ditugaskan');
            $table->foreignId('ditugaskan_oleh')->constrained('users_m');
            $table->timestamps();

            $table->unique(['proposal_id', 'peran']);
            $table->unique(['proposal_id', 'reviewer_dosen_id']);
            $table->index('reviewer_dosen_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_reviewer_t');
    }
};
