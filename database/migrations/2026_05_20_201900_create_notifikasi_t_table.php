<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users_m')->cascadeOnDelete();
            $table->string('judul', 200);
            $table->text('pesan');
            $table->string('link', 500)->nullable();
            $table->string('icon', 50)->nullable();
            $table->timestamp('dibaca_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'dibaca_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_t');
    }
};
