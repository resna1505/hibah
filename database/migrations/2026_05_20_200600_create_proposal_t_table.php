<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_t', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_hibah_id')->constrained('periode_hibah_t');
            $table->foreignId('skema_hibah_id')->constrained('skema_hibah_m');
            $table->foreignId('ketua_dosen_id')->constrained('dosen_m');

            $table->string('judul', 500);
            $table->text('ringkasan')->nullable();
            $table->string('kata_kunci', 300)->nullable();
            $table->longText('pendahuluan')->nullable();
            $table->longText('metode')->nullable();
            $table->string('metode_diagram_path')->nullable();
            $table->json('hasil_diharapkan_json')->nullable()->comment('Array of {jenis_luaran, target, hasil}');
            $table->json('jadwal_json')->nullable()->comment('Array of {keterangan, bulan_array}');
            $table->longText('daftar_pustaka')->nullable();
            $table->longText('permasalahan_solusi')->nullable()->comment('Khusus PKM');

            $table->unsignedBigInteger('total_anggaran')->default(0);
            $table->unsignedTinyInteger('durasi_bulan')->default(12);

            $table->enum('status', [
                'draft',
                'submitted',
                'verifikasi',
                'dikembalikan',
                'direview',
                'revisi_minor',
                'revisi_mayor',
                'disetujui',
                'ditolak',
                'berjalan',
                'selesai',
                'ditarik',
            ])->default('draft');

            $table->boolean('pernyataan_setuju')->default(false);
            $table->timestamp('tgl_submit')->nullable();
            $table->timestamps();

            $table->index(['status', 'periode_hibah_id']);
            // 1 dosen 1 ketua per skema per periode
            $table->unique(
                ['periode_hibah_id', 'ketua_dosen_id', 'skema_hibah_id'],
                'unique_ketua_skema_periode'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_t');
    }
};
