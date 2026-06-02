<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            // Pasang index pengganti untuk FK periode_hibah_id (sebelumnya di-cover oleh unique composite)
            $table->index('periode_hibah_id', 'idx_proposal_periode');
        });
        Schema::table('proposal_t', function (Blueprint $table) {
            // Hapus batasan "1 dosen 1 proposal per skema per periode".
            // Aturan baru: dosen boleh maks 2 per jenis per periode, dijaga di controller.
            $table->dropUnique('unique_ketua_skema_periode');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            $table->unique(
                ['periode_hibah_id', 'ketua_dosen_id', 'skema_hibah_id'],
                'unique_ketua_skema_periode'
            );
            $table->dropIndex('idx_proposal_periode');
        });
    }
};
