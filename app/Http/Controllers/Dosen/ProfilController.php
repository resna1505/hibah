<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Master\Fakultas;
use App\Models\Master\Keahlian;
use App\Models\Master\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $dosen = $user->dosen;

        $eligibilityIssues = $dosen
            ? app(\App\Services\ProposalService::class)->checkKetuaEligibility($dosen)
            : ['Akun belum terhubung dengan profil dosen.'];

        return view('dosen.profil.edit', [
            'user' => $user,
            'dosen' => $dosen,
            'fakultasList' => Fakultas::where('is_active', true)->orderBy('nama')->get(),
            'prodiList' => Prodi::where('is_active', true)->orderBy('nama')->get(),
            'keahlianList' => Keahlian::where('is_active', true)->orderBy('nama')->get(),
            'keahlianIds' => $dosen?->keahlian->pluck('id')->all() ?? [],
            'eligibilityIssues' => $eligibilityIssues,
            'syaratPendidikan' => \App\Models\Master\Pengaturan::get('syarat_ketua_pendidikan_min', 'S3'),
            'syaratJabatan'    => \App\Models\Master\Pengaturan::get('syarat_ketua_jabatan_min', 'Lektor'),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $dosen = $user->dosen;

        $data = $request->validate([
            'nama_lengkap'        => 'required|string|max:200',
            'email'               => ['nullable', 'email', 'max:255', Rule::unique('users_m', 'email')->ignore($user->id)],
            'no_hp'               => 'nullable|string|max:25',
            'nidn'                => ['nullable', 'string', 'max:20', Rule::unique('dosen_m', 'nidn')->ignore($dosen?->id)],
            'nidk'                => ['nullable', 'string', 'max:20', Rule::unique('dosen_m', 'nidk')->ignore($dosen?->id)],
            'fakultas_id'         => 'required|exists:fakultas_m,id',
            'prodi_id'            => 'required|exists:prodi_m,id',
            'jabatan_fungsional'  => 'nullable|in:Tenaga Pengajar,Asisten Ahli,Lektor,Lektor Kepala,Profesor',
            'pangkat_golongan'    => 'nullable|string|max:30',
            'pendidikan_terakhir' => 'nullable|in:S1,S2,S3',
            'scopus_id'           => 'nullable|string|max:50',
            'google_scholar_id'   => 'nullable|string|max:100',
            'sinta_id'            => 'nullable|string|max:50',
            'sinta_score'         => 'nullable|integer|min:0',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ttd'                 => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'hapus_ttd'           => 'nullable|boolean',
            'keahlian_ids'        => 'array',
            'keahlian_ids.*'      => 'exists:keahlian_m,id',
        ]);

        $user->update([
            'email' => $data['email'] ?? null,
        ]);

        $dosenPayload = collect($data)
            ->except(['email', 'keahlian_ids', 'foto', 'ttd', 'hapus_ttd'])
            ->all();

        if ($request->hasFile('foto')) {
            $dosenPayload['foto_path'] = $request->file('foto')->store('dosen/foto', 'public');
        }

        if ($request->boolean('hapus_ttd') && $dosen->ttd_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dosen->ttd_path);
            $dosenPayload['ttd_path'] = null;
        }
        if ($request->hasFile('ttd')) {
            if ($dosen->ttd_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($dosen->ttd_path);
            }
            $dosenPayload['ttd_path'] = $request->file('ttd')->store('dosen/ttd', 'public');
        }

        $dosen->update($dosenPayload);
        $dosen->keahlian()->sync($data['keahlian_ids'] ?? []);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(6)],
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->with('error', 'Gagal mengubah password.');
        }

        $user->update(['password' => $data['password']]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
