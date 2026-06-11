<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pasang index pengganti untuk FK periode_hibah_id (sebelumnya di-cover oleh unique composite).
        // Guard: hanya tambah jika belum ada (idempotent — aman bila sebagian sudah ter-apply).
        if (! $this->indexExists('proposal_t', 'idx_proposal_periode')) {
            Schema::table('proposal_t', function (Blueprint $table) {
                $table->index('periode_hibah_id', 'idx_proposal_periode');
            });
        }

        // Hapus batasan "1 dosen 1 proposal per skema per periode".
        // Aturan baru: dosen boleh maks 2 per jenis per periode, dijaga di controller.
        if ($this->indexExists('proposal_t', 'unique_ketua_skema_periode')) {
            Schema::table('proposal_t', function (Blueprint $table) {
                $table->dropUnique('unique_ketua_skema_periode');
            });
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        return collect(DB::select("SHOW INDEXES FROM `{$table}` WHERE Key_name = ?", [$index]))->isNotEmpty();
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
