<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Transaction\RiwayatPkm;
use Illuminate\Http\Request;

class RiwayatPkmController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403, 'Akun dosen tidak ditemukan.');

        $list = RiwayatPkm::where('dosen_id', $dosen->id)
            ->orderByDesc('tahun')
            ->get();

        return view('dosen.riwayat.pkm', compact('list'));
    }

    public function store(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403);

        $data = $request->validate([
            'tahun'       => 'required|integer|min:1990|max:' . (now()->year + 1),
            'judul'       => 'required|string|max:500',
            'skema_pkm'   => 'nullable|string|max:100',
            'sumber_dana' => 'nullable|string|max:150',
            'peran'       => 'required|in:ketua,anggota',
            'lokasi'      => 'nullable|string|max:200',
            'mitra'       => 'nullable|string|max:200',
            'luaran'      => 'nullable|string|max:300',
            'status'      => 'required|in:selesai,berjalan',
        ]);

        RiwayatPkm::create(array_merge($data, ['dosen_id' => $dosen->id]));

        return back()->with('success', 'Riwayat PKM berhasil ditambahkan.');
    }

    public function update(Request $request, RiwayatPkm $riwayat_pkm)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $riwayat_pkm->dosen_id === $dosen->id, 403);

        $data = $request->validate([
            'tahun'       => 'required|integer|min:1990|max:' . (now()->year + 1),
            'judul'       => 'required|string|max:500',
            'skema_pkm'   => 'nullable|string|max:100',
            'sumber_dana' => 'nullable|string|max:150',
            'peran'       => 'required|in:ketua,anggota',
            'lokasi'      => 'nullable|string|max:200',
            'mitra'       => 'nullable|string|max:200',
            'luaran'      => 'nullable|string|max:300',
            'status'      => 'required|in:selesai,berjalan',
        ]);

        $riwayat_pkm->update($data);
        return back()->with('success', 'Riwayat PKM diperbarui.');
    }

    public function destroy(Request $request, RiwayatPkm $riwayat_pkm)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $riwayat_pkm->dosen_id === $dosen->id, 403);

        $riwayat_pkm->delete();

        return back()->with('success', 'Riwayat PKM dihapus.');
    }
}
