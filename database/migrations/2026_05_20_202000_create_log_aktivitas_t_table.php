<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_aktivitas_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users_m')->nullOnDelete();
            $table->string('modul', 100);
            $table->string('aktivitas', 150);
            $table->text('deskripsi')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
            $table->index('modul');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas_t');
    }
};
