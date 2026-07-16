<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterProdiController extends Controller
{
    private array $jenjangOpsi = ['D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'];

    public function store(Request $request)
    {
        $data = $request->validate([
            'fakultas_id' => 'required|exists:fakultas_m,id',
            'kode'        => 'required|string|max:20|unique:prodi_m,kode',
            'nama'        => 'required|string|max:150',
            'jenjang'     => ['required', Rule::in($this->jenjangOpsi)],
        ], [
            'kode.unique' => 'Kode program studi sudah dipakai. Gunakan kode lain.',
        ]);

        $data['is_active'] = true;
        Prodi::create($data);

        return back()->with('success', "Program studi '{$data['nama']}' ditambahkan.");
    }

    public function update(Request $request, Prodi $prodi)
    {
        $data = $request->validate([
            'fakultas_id' => 'required|exists:fakultas_m,id',
            'kode'        => ['required', 'string', 'max:20', Rule::unique('prodi_m', 'kode')->ignore($prodi->id)],
            'nama'        => 'required|string|max:150',
            'jenjang'     => ['required', Rule::in($this->jenjangOpsi)],
            'is_active'   => 'nullable|boolean',
        ], [
            'kode.unique' => 'Kode program studi sudah dipakai. Gunakan kode lain.',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? $prodi->is_active);
        $prodi->update($data);

        return back()->with('success', 'Program studi diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        $jumlahPakai = Dosen::where('prodi_id', $prodi->id)->count();
        if ($jumlahPakai > 0) {
            return back()->with('error', "Tidak bisa dihapus — program studi ini dipakai oleh {$jumlahPakai} dosen. Nonaktifkan saja (uncheck 'Aktif') agar tidak muncul lagi di form.");
        }

        $prodi->delete();
        return back()->with('success', 'Program studi dihapus.');
    }
}
