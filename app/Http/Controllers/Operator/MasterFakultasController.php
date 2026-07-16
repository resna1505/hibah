<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterFakultasController extends Controller
{
    public function index()
    {
        $fakultasList = Fakultas::with(['prodi' => fn($q) => $q->orderBy('kode')])
            ->orderBy('nama')
            ->get();

        // Pemakaian oleh dosen (untuk peringatan sebelum hapus).
        $prodiUsage = Dosen::selectRaw('prodi_id, COUNT(*) AS jumlah')
            ->whereNotNull('prodi_id')->groupBy('prodi_id')->pluck('jumlah', 'prodi_id');
        $fakultasUsage = Dosen::selectRaw('fakultas_id, COUNT(*) AS jumlah')
            ->whereNotNull('fakultas_id')->groupBy('fakultas_id')->pluck('jumlah', 'fakultas_id');

        return view('operator.master.fakultas.index', [
            'fakultasList'  => $fakultasList,
            'prodiUsage'    => $prodiUsage,
            'fakultasUsage' => $fakultasUsage,
            'jenjangOpsi'   => ['D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:20|unique:fakultas_m,kode',
            'nama' => 'required|string|max:150',
        ], [
            'kode.unique' => 'Kode fakultas sudah dipakai. Gunakan kode lain.',
        ]);

        $data['is_active'] = true;
        Fakultas::create($data);

        return back()->with('success', "Fakultas '{$data['nama']}' ditambahkan.");
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        $data = $request->validate([
            'kode'      => ['required', 'string', 'max:20', Rule::unique('fakultas_m', 'kode')->ignore($fakultas->id)],
            'nama'      => 'required|string|max:150',
            'is_active' => 'nullable|boolean',
        ], [
            'kode.unique' => 'Kode fakultas sudah dipakai. Gunakan kode lain.',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? $fakultas->is_active);
        $fakultas->update($data);

        return back()->with('success', 'Fakultas diperbarui.');
    }

    public function destroy(Fakultas $fakultas)
    {
        $jumlahProdi = $fakultas->prodi()->count();
        if ($jumlahProdi > 0) {
            return back()->with('error', "Tidak bisa dihapus — fakultas ini masih memiliki {$jumlahProdi} program studi. Hapus atau pindahkan prodi-nya dulu.");
        }

        $jumlahDosen = Dosen::where('fakultas_id', $fakultas->id)->count();
        if ($jumlahDosen > 0) {
            return back()->with('error', "Tidak bisa dihapus — fakultas ini dipakai oleh {$jumlahDosen} dosen. Nonaktifkan saja agar tidak muncul di pilihan.");
        }

        $fakultas->delete();
        return back()->with('success', 'Fakultas dihapus.');
    }
}
