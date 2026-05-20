<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->string('ttd_path')->nullable()->after('foto_path');
        });
    }

    public function down(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->dropColumn('ttd_path');
        });
    }
};
