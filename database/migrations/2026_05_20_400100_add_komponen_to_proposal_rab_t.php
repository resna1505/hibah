<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_rab_t', function (Blueprint $table) {
            $table->foreignId('komponen_rab_id')->nullable()->after('kategori_rab_id')
                ->constrained('komponen_rab_m')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('proposal_rab_t', function (Blueprint $table) {
            $table->dropConstrainedForeignId('komponen_rab_id');
        });
    }
};
