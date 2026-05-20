<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\KategoriRab;
use App\Models\Master\KomponenRab;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterRabController extends Controller
{
    public function index()
    {
        $kelompok = KategoriRab::with(['komponen' => fn($q) => $q->orderBy('urutan')])
            ->orderBy('urutan')->get();

        return view('operator.master.rab.index', compact('kelompok'));
    }

    public function storeKelompok(Request $request)
    {
        $data = $request->validate([
            'kode'   => 'required|string|max:30|unique:kategori_rab_m,kode',
            'nama'   => 'required|string|max:100',
            'urutan' => 'nullable|integer|min:0|max:99',
        ]);
        $data['urutan'] = $data['urutan'] ?? ((KategoriRab::max('urutan') ?? 0) + 1);
        $data['is_active'] = true;
        KategoriRab::create($data);

        return back()->with('success', "Kelompok '{$data['nama']}' ditambahkan.");
    }

    public function updateKelompok(Request $request, KategoriRab $kelompok)
    {
        $data = $request->validate([
            'kode'      => 'required|string|max:30|unique:kategori_rab_m,kode,' . $kelompok->id,
            'nama'      => 'required|string|max:100',
            'urutan'    => 'nullable|integer|min:0|max:99',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? $kelompok->is_active);
        $kelompok->update($data);

        return back()->with('success', 'Kelompok diperbarui.');
    }

    public function destroyKelompok(KategoriRab $kelompok)
    {
        if ($kelompok->komponen()->exists()) {
            return back()->with('error', 'Hapus komponen di dalamnya dulu.');
        }
        if ($kelompok->id && \App\Models\Transaction\ProposalRab::where('kategori_rab_id', $kelompok->id)->exists()) {
            return back()->with('error', 'Kelompok dipakai di RAB proposal, tidak bisa dihapus.');
        }

        $kelompok->delete();
        return back()->with('success', 'Kelompok dihapus.');
    }

    public function storeKomponen(Request $request, KategoriRab $kelompok)
    {
        $data = $request->validate([
            'kode'   => 'nullable|string|max:40',
            'nama'   => 'required|string|max:200',
            'urutan' => 'nullable|integer|min:0|max:999',
        ]);

        $data['kode'] = $data['kode'] ?: Str::slug($data['nama'], '_');
        $data['urutan'] = $data['urutan'] ?? ((KomponenRab::where('kategori_rab_id', $kelompok->id)->max('urutan') ?? 0) + 1);

        // Pastikan unique per kelompok
        if (KomponenRab::where('kategori_rab_id', $kelompok->id)->where('kode', $data['kode'])->exists()) {
            return back()->withErrors(['kode' => 'Kode komponen sudah dipakai di kelompok ini.'])->withInput();
        }

        KomponenRab::create([
            'kategori_rab_id' => $kelompok->id,
            'kode'   => $data['kode'],
            'nama'   => $data['nama'],
            'urutan' => $data['urutan'],
            'is_active' => true,
        ]);

        return back()->with('success', "Komponen '{$data['nama']}' ditambahkan.");
    }

    public function updateKomponen(Request $request, KomponenRab $komponen)
    {
        $data = $request->validate([
            'kode'      => 'required|string|max:40',
            'nama'      => 'required|string|max:200',
            'urutan'    => 'nullable|integer|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        $clash = KomponenRab::where('kategori_rab_id', $komponen->kategori_rab_id)
            ->where('kode', $data['kode'])
            ->where('id', '!=', $komponen->id)
            ->exists();
        if ($clash) {
            return back()->withErrors(['kode' => 'Kode komponen sudah dipakai di kelompok ini.'])->withInput();
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? $komponen->is_active);
        $komponen->update($data);

        return back()->with('success', 'Komponen diperbarui.');
    }

    public function destroyKomponen(KomponenRab $komponen)
    {
        if (\App\Models\Transaction\ProposalRab::where('komponen_rab_id', $komponen->id)->exists()) {
            return back()->with('error', 'Komponen dipakai di RAB proposal, tidak bisa dihapus.');
        }
        $komponen->delete();
        return back()->with('success', 'Komponen dihapus.');
    }
}
