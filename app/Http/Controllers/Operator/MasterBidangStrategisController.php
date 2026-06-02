<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\BidangStrategis;
use App\Models\Transaction\Proposal;
use Illuminate\Http\Request;

class MasterBidangStrategisController extends Controller
{
    public function index()
    {
        $list = BidangStrategis::orderBy('kode')->get();

        // Hitung jumlah proposal yang sudah pakai (untuk warning sebelum hapus)
        $usage = Proposal::selectRaw('bidang_strategis_id, COUNT(*) AS jumlah')
            ->whereNotNull('bidang_strategis_id')
            ->groupBy('bidang_strategis_id')
            ->pluck('jumlah', 'bidang_strategis_id');

        return view('operator.master.bidang.index', compact('list', 'usage'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode'      => 'required|integer|min:1|max:99|unique:bidang_strategis_m,kode',
            'nama'      => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kode.unique' => 'Kode bidang sudah dipakai. Pilih nomor lain.',
        ]);

        $data['is_active'] = true;
        BidangStrategis::create($data);

        return back()->with('success', "Bidang strategis '{$data['nama']}' ditambahkan.");
    }

    public function update(Request $request, BidangStrategis $bidang)
    {
        $data = $request->validate([
            'kode'      => 'required|integer|min:1|max:99|unique:bidang_strategis_m,kode,' . $bidang->id,
            'nama'      => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ], [
            'kode.unique' => 'Kode bidang sudah dipakai. Pilih nomor lain.',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? $bidang->is_active);
        $bidang->update($data);

        return back()->with('success', 'Bidang strategis diperbarui.');
    }

    public function destroy(BidangStrategis $bidang)
    {
        $jumlahPakai = Proposal::where('bidang_strategis_id', $bidang->id)->count();
        if ($jumlahPakai > 0) {
            return back()->with('error', "Tidak bisa dihapus — bidang ini sudah dipakai di {$jumlahPakai} proposal. Nonaktifkan saja (uncheck 'Aktif') agar tidak muncul lagi di form dosen.");
        }

        $bidang->delete();
        return back()->with('success', 'Bidang strategis dihapus.');
    }
}
