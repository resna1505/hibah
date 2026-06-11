<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->boolean('is_ketua_eligible')->default(false)->after('is_reviewer');
        });

        // Kontinuitas: dosen yang sudah pernah menjadi ketua proposal tetap boleh jadi ketua,
        // supaya proposal yang sedang berjalan tidak ikut terblokir.
        DB::statement('UPDATE dosen_m SET is_ketua_eligible = 1
            WHERE id IN (SELECT ketua_dosen_id FROM proposal_t WHERE ketua_dosen_id IS NOT NULL)');

        // Setelan ambang lama (pendidikan/jabatan min) diganti penanda per dosen — hapus agar tak membingungkan.
        DB::table('pengaturan_m')->whereIn('kunci', [
            'syarat_ketua_pendidikan_min',
            'syarat_ketua_jabatan_min',
        ])->delete();
    }

    public function down(): void
    {
        Schema::table('dosen_m', function (Blueprint $table) {
            $table->dropColumn('is_ketua_eligible');
        });

        $now = now();
        DB::table('pengaturan_m')->insert([
            ['kunci' => 'syarat_ketua_pendidikan_min', 'label' => 'Syarat Ketua: Pendidikan Min', 'tipe' => 'text', 'grup' => 'syarat', 'nilai' => 'S3', 'created_at' => $now, 'updated_at' => $now],
            ['kunci' => 'syarat_ketua_jabatan_min', 'label' => 'Syarat Ketua: Jabatan Min', 'tipe' => 'text', 'grup' => 'syarat', 'nilai' => 'Lektor', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
};
