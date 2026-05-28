<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->unsignedBigInteger('fakultas_id')->nullable()->change();
            $table->unsignedBigInteger('prodi_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->unsignedBigInteger('fakultas_id')->nullable(false)->change();
            $table->unsignedBigInteger('prodi_id')->nullable(false)->change();
        });
    }
};
