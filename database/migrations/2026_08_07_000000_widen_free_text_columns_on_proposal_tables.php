<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom-kolom di bawah ini diisi dosen sebagai uraian, bukan frasa pendek,
     * sehingga batas VARCHAR aslinya sering terlampaui dan penyimpanan draft gagal
     * dengan SQLSTATE[22001] (Data too long for column ...). Diubah ke TEXT agar
     * pengisian tidak dibatasi secara artifisial.
     */
    public function up(): void
    {
        Schema::table('proposal_anggota_t', function (Blueprint $table) {
            $table->text('bidang_tugas')->nullable()->change();
        });

        Schema::table('proposal_rab_t', function (Blueprint $table) {
            $table->text('item')->change();
            $table->text('justifikasi')->nullable()->change();
        });

        // Catatan: change() menulis ulang definisi kolom, jadi atribut lama
        // (nullable, comment) harus disebutkan ulang agar tidak ikut terhapus.
        Schema::table('rencana_luaran_t', function (Blueprint $table) {
            $table->text('jenis_luaran_text')->nullable()
                ->comment('Bila tidak terdaftar di master')->change();
            $table->string('status_target', 255)->nullable()
                ->comment('Submitted/Accepted/Published/Granted/dll')->change();
        });
    }

    public function down(): void
    {
        Schema::table('proposal_anggota_t', function (Blueprint $table) {
            $table->string('bidang_tugas', 300)->nullable()->change();
        });

        Schema::table('proposal_rab_t', function (Blueprint $table) {
            $table->string('item', 300)->change();
            $table->string('justifikasi', 500)->nullable()->change();
        });

        Schema::table('rencana_luaran_t', function (Blueprint $table) {
            $table->string('jenis_luaran_text', 200)->nullable()
                ->comment('Bila tidak terdaftar di master')->change();
            $table->string('status_target', 100)->nullable()
                ->comment('Submitted/Accepted/Published/Granted/dll')->change();
        });
    }
};
