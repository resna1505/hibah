<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Transaction\RiwayatHki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatHkiController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403, 'Akun dosen tidak ditemukan.');

        $list = RiwayatHki::where('dosen_id', $dosen->id)
            ->orderByDesc('tahun_pengajuan')
            ->get();

        return view('dosen.riwayat.hki', compact('list'));
    }

    public function store(Request $request)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen, 403);

        $data = $request->validate([
            'jenis_hki'       => 'required|in:Hak Cipta,Paten,Merek,Desain Industri,Rahasia Dagang,Lainnya',
            'judul'           => 'required|string|max:500',
            'no_pendaftaran'  => 'nullable|string|max:100',
            'no_sertifikat'   => 'nullable|string|max:100',
            'tahun_pengajuan' => 'nullable|integer|min:1990|max:' . (now()->year + 1),
            'tahun_terbit'    => 'nullable|integer|min:1990|max:' . (now()->year + 1),
            'status_hki'      => 'required|in:Terdaftar,Proses,Granted',
            'peran'           => 'required|in:ketua,anggota',
            'file'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('dosen/hki', 'public');
        }
        unset($data['file']);

        RiwayatHki::create(array_merge($data, ['dosen_id' => $dosen->id]));

        return back()->with('success', 'Riwayat HKI berhasil ditambahkan.');
    }

    public function destroy(Request $request, RiwayatHki $riwayat_hki)
    {
        $dosen = $request->user()->dosen;
        abort_unless($dosen && $riwayat_hki->dosen_id === $dosen->id, 403);

        if ($riwayat_hki->file_path && Storage::disk('public')->exists($riwayat_hki->file_path)) {
            Storage::disk('public')->delete($riwayat_hki->file_path);
        }
        $riwayat_hki->delete();

        return back()->with('success', 'Riwayat HKI dihapus.');
    }
}
