<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            $table->foreignId('bidang_strategis_id')->nullable()->after('skema_hibah_id')->constrained('bidang_strategis_m')->nullOnDelete();
            $table->text('rumusan_masalah_bidang')->nullable()->after('bidang_strategis_id');
            $table->text('uraian_bidang')->nullable()->after('rumusan_masalah_bidang');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bidang_strategis_id');
            $table->dropColumn(['rumusan_masalah_bidang', 'uraian_bidang']);
        });
    }
};
