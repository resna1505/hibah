<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_mitra_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->string('nama_mitra', 200);
            $table->string('pimpinan_mitra', 200)->nullable();
            $table->text('alamat_mitra')->nullable();
            $table->text('permasalahan_mitra')->nullable();
            $table->timestamps();

            $table->index('proposal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_mitra_t');
    }
};
