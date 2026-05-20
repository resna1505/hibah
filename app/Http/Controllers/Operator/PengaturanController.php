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
            'lppm_kop'          => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        foreach ($data['nilai'] ?? [] as $kunci => $nilai) {
            Pengaturan::where('kunci', $kunci)->update(['nilai' => $nilai]);
        }

        if ($request->hasFile('lppm_ttd')) {
            $old = Pengaturan::get('lppm_ttd_path');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('lppm_ttd')->store('pengaturan', 'public');
            Pengaturan::set('lppm_ttd_path', $path);
        }

        if ($request->hasFile('lppm_kop')) {
            $old = Pengaturan::get('lppm_kop_path');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('lppm_kop')->store('pengaturan', 'public');
            Pengaturan::set('lppm_kop_path', $path);
        }

        \Illuminate\Support\Facades\Cache::forget('pengaturan_all');

        return back()->with('success', 'Pengaturan tersimpan.');
    }
}
