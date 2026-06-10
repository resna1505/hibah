<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_mitra_t', function (Blueprint $table) {
            $table->string('dokumen_path')->nullable()->after('permasalahan_mitra');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_mitra_t', function (Blueprint $table) {
            $table->dropColumn('dokumen_path');
        });
    }
};
