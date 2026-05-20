<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            $table->string('no_registrasi', 60)->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_t', function (Blueprint $table) {
            $table->dropUnique(['no_registrasi']);
            $table->dropColumn('no_registrasi');
        });
    }
};
