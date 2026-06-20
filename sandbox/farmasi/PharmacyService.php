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
        $sql = "SELECT id, name, stock, is_narcotic FROM medicines
                WHERE name LIKE '%" . $name . "%'
                ORDER BY name ASC";

        return DB::select($sql);
    }

    /**
     * Keluarkan (dispense) obat untuk satu pasien.
     * Mengurangi stok dan mencatat transaksi.
     */
    public function dispense(array $user, int $medicineId, int $qty): array
    {
        $medicine = DB::table('medicines')->where('id', $medicineId)->first();

        if (! $medicine) {
            return ['ok' => false, 'message' => 'Obat tidak ditemukan'];
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
    }

    /**
     * Sesuaikan stok secara manual (stock opname / koreksi gudang).
     */
    public function adjustStock(array $user, int $medicineId, int $newStock): array
    {
        DB::table('medicines')
            ->where('id', $medicineId)
            ->update(['stock' => $newStock]);

        return ['ok' => true, 'message' => 'Stok diperbarui', 'stock' => $newStock];
    }
}
