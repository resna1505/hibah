<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $items = Pengaturan::orderBy('grup')->orderBy('id')->get()->groupBy('grup');

        return view('operator.pengaturan.index', [
            'grouped' => $items,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nilai'             => 'array',
            'nilai.*'           => 'nullable|string|max:1000',
            'lppm_ttd'          => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'kop_kiri'          => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'kop_kanan'         => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        foreach ($data['nilai'] ?? [] as $kunci => $nilai) {
            Pengaturan::where('kunci', $kunci)->update(['nilai' => $nilai]);
        }

        foreach ([
            'lppm_ttd'  => 'lppm_ttd_path',
            'kop_kiri'  => 'kop_kiri_path',
            'kop_kanan' => 'kop_kanan_path',
        ] as $field => $kunci) {
            if ($request->hasFile($field)) {
                $old = Pengaturan::get($kunci);
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($field)->store('pengaturan', 'public');
                Pengaturan::set($kunci, $path);
            }
        }

        \Illuminate\Support\Facades\Cache::forget('pengaturan_all');

        return back()->with('success', 'Pengaturan tersimpan.');
    }
}
