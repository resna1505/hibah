<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Transaction\RiwayatPenelitian;
use Illuminate\Http\Request;

class RiwayatPenelitianController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403, 'Akun dosen tidak ditemukan.');

        $list = RiwayatPenelitian::where('dosen_id', $dosen->id)
            ->orderByDesc('tahun')
            ->get();

        return view('dosen.riwayat.penelitian', compact('list'));
    }

    public function store(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403);

        $data = $request->validate([
            'tahun'            => 'required|integer|min:1990|max:' . (now()->year + 1),
            'judul'            => 'required|string|max:500',
            'sumber_pendanaan' => 'nullable|string|max:150',
            'skema_penelitian' => 'nullable|string|max:100',
            'peran'            => 'required|in:ketua,anggota',
            'status'           => 'required|in:selesai,berjalan',
            'luaran'           => 'nullable|string|max:300',
        ]);

        RiwayatPenelitian::create(array_merge($data, ['dosen_id' => $dosen->id]));

        return back()->with('success', 'Riwayat penelitian berhasil ditambahkan.');
    }

    public function update(Request $request, RiwayatPenelitian $riwayat_penelitian)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $riwayat_penelitian->dosen_id === $dosen->id, 403);

        $data = $request->validate([
            'tahun'            => 'required|integer|min:1990|max:' . (now()->year + 1),
            'judul'            => 'required|string|max:500',
            'sumber_pendanaan' => 'nullable|string|max:150',
            'skema_penelitian' => 'nullable|string|max:100',
            'peran'            => 'required|in:ketua,anggota',
            'status'           => 'required|in:selesai,berjalan',
            'luaran'           => 'nullable|string|max:300',
        ]);

        $riwayat_penelitian->update($data);
        return back()->with('success', 'Riwayat penelitian diperbarui.');
    }

    public function destroy(Request $request, RiwayatPenelitian $riwayat_penelitian)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $riwayat_penelitian->dosen_id === $dosen->id, 403);

        $riwayat_penelitian->delete();

        return back()->with('success', 'Riwayat penelitian dihapus.');
    }
}
