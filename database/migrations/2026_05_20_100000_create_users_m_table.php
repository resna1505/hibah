<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_m', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 30)->unique()->comment('Nomor Induk Karyawan UNIBA, dipakai untuk login');
            $table->string('username', 50)->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['operator', 'dosen'])->default('dosen');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index(['role', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_m');
    }
};
