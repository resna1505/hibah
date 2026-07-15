<?php

namespace Sandbox\Farmasi;

use Illuminate\Support\Facades\DB;

/**
 * Modul DUMMY untuk simulasi belajar workflow agent.
 * BUKAN kode produksi. Meniru pola umum service farmasi SIMRS:
 * cari obat, lihat stok, dan dispensing (pengeluaran obat ke pasien).
 */
class PharmacyService
{
    /**
     * Cari obat berdasarkan nama (untuk autocomplete di kasir farmasi).
     */
    public function searchByName(string $name): array
    {
        // Gunakan parameter binding agar aman dari SQL injection.
        // Karakter wildcard LIKE (% dan _) di-escape supaya input user
        // tidak diperlakukan sebagai pola.
        $escaped = addcslashes($name, '%_\\');

        $sql = "SELECT id, name, stock, is_narcotic FROM medicines
                WHERE name LIKE ?
                ORDER BY name ASC";

        return DB::select($sql, ['%' . $escaped . '%']);
    }

    /**
     * Keluarkan (dispense) obat untuk satu pasien.
     * Mengurangi stok dan mencatat transaksi.
     */
    public function dispense(array $user, int $medicineId, int $qty): array
    {
        // Validasi jumlah: harus bilangan positif. Mencegah qty nol/negatif
        // yang justru bisa MENAMBAH stok (bahaya untuk obat & narkotika).
        if ($qty <= 0) {
            return ['ok' => false, 'message' => 'Jumlah dispense harus lebih dari 0'];
        }

        // Bungkus dalam transaksi + lock baris agar pembacaan dan pengurangan
        // stok bersifat atomik. Tanpa ini, dispense paralel bisa membuat stok
        // korup (race condition) — kritis untuk integritas data obat.
        return DB::transaction(function () use ($user, $medicineId, $qty) {
            $medicine = DB::table('medicines')
                ->where('id', $medicineId)
                ->lockForUpdate()
                ->first();

            if (! $medicine) {
                return ['ok' => false, 'message' => 'Obat tidak ditemukan'];
            }

            // Cegah stok minus: tidak boleh dispense melebihi stok tersedia.
            if ($qty > $medicine->stock) {
                return [
                    'ok'      => false,
                    'message' => 'Stok tidak mencukupi',
                ];
            }

            $newStock = $medicine->stock - $qty;

            DB::table('medicines')
                ->where('id', $medicineId)
                ->update(['stock' => $newStock]);

            DB::table('dispense_logs')->insert([
                'medicine_id' => $medicineId,
                'qty'         => $qty,
                'by_user'     => $user['id'],
                'created_at'  => now(),
            ]);

            return [
                'ok'        => true,
                'message'   => 'Berhasil dispense',
                'new_stock' => $newStock,
            ];
        });
    }

    /**
     * Sesuaikan stok secara manual (stock opname / koreksi gudang).
     */
    public function adjustStock(array $user, int $medicineId, int $newStock): array
    {
        // Stok hasil koreksi tidak boleh negatif.
        if ($newStock < 0) {
            return ['ok' => false, 'message' => 'Stok tidak boleh negatif'];
        }

        // Koreksi stok harus atomik dan WAJIB tercatat (jejak audit).
        // Untuk obat/narkotika, perubahan stok manual tanpa audit trail
        // adalah celah kepatuhan dan keselamatan yang serius.
        return DB::transaction(function () use ($user, $medicineId, $newStock) {
            $medicine = DB::table('medicines')
                ->where('id', $medicineId)
                ->lockForUpdate()
                ->first();

            if (! $medicine) {
                return ['ok' => false, 'message' => 'Obat tidak ditemukan'];
            }

            DB::table('medicines')
                ->where('id', $medicineId)
                ->update(['stock' => $newStock]);

            // Catat koreksi manual: stok lama, stok baru, dan siapa yang mengubah.
            DB::table('dispense_logs')->insert([
                'medicine_id' => $medicineId,
                'qty'         => $newStock - $medicine->stock,
                'by_user'     => $user['id'],
                'created_at'  => now(),
            ]);

            return ['ok' => true, 'message' => 'Stok diperbarui', 'stock' => $newStock];
        });
    }
}
