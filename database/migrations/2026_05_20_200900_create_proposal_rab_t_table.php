<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_rab_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_t')->cascadeOnDelete();
            $table->foreignId('kategori_rab_id')->constrained('kategori_rab_m');
            $table->string('item', 300);
            $table->string('justifikasi', 500)->nullable();
            $table->decimal('kuantitas', 12, 2)->default(1);
            $table->string('satuan', 50)->nullable();
            $table->unsignedBigInteger('harga_satuan')->default(0);
            $table->unsignedBigInteger('sub_total')->default(0);
            $table->timestamps();

            $table->index(['proposal_id', 'kategori_rab_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_rab_t');
    }
};
