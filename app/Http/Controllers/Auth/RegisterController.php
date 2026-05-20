<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Master\Fakultas;
use App\Models\Master\Keahlian;
use App\Models\Master\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'fakultasList'  => Fakultas::where('is_active', true)->orderBy('nama')->get(),
            'prodiList'     => Prodi::where('is_active', true)->orderBy('nama')->get(['id', 'fakultas_id', 'nama']),
            'keahlianList'  => Keahlian::where('is_active', true)->orderBy('nama')->get(),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            // Akun
            'nik'           => 'required|string|max:30|unique:users_m,nik',
            'email'         => 'required|email|max:255|unique:users_m,email',
            'password'      => ['required', 'confirmed', Password::min(6)],

            // Identitas dosen
            'nama_lengkap'  => 'required|string|max:200',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nidn'          => 'nullable|string|max:20|unique:dosen_m,nidn',
            'nidk'          => 'nullable|string|max:20|unique:dosen_m,nidk',

            // Akademik
            'fakultas_id'         => 'required|exists:fakultas_m,id',
            'prodi_id'            => 'required|exists:prodi_m,id',
            'jabatan_fungsional'  => 'nullable|in:Tenaga Pengajar,Asisten Ahli,Lektor,Lektor Kepala,Profesor',
            'pangkat_golongan'    => 'nullable|string|max:30',
            'pendidikan_terakhir' => 'nullable|in:S1,S2,S3',
            'keahlian_ids'        => 'array',
            'keahlian_ids.*'      => 'exists:keahlian_m,id',

            // Kontak
            'no_hp' => 'nullable|string|max:25',

            // External ID
            'scopus_id'         => 'nullable|string|max:50',
            'google_scholar_id' => 'nullable|string|max:100',
            'sinta_id'          => 'nullable|string|max:50',
            'sinta_score'       => 'nullable|integer|min:0',

            // Persetujuan
            'agreement' => 'accepted',
        ], [
            'nik.unique'   => 'NIK sudah terdaftar. Silakan login atau gunakan NIK lain.',
            'email.unique' => 'Email sudah terdaftar.',
            'nidn.unique'  => 'NIDN sudah terdaftar pada dosen lain.',
            'nidk.unique'  => 'NIDK sudah terdaftar pada dosen lain.',
            'agreement.accepted' => 'Anda wajib menyetujui pernyataan untuk mendaftar.',
        ]);

        // Wajib salah satu: NIDN atau NIDK
        if (empty($data['nidn']) && empty($data['nidk'])) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'foto']))
                ->withErrors(['nidn' => 'NIDN atau NIDK wajib diisi salah satu.']);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dosen/foto', 'public');
        }

        DB::transaction(function () use ($data, $fotoPath) {
            $user = User::create([
                'nik'       => $data['nik'],
                'email'     => $data['email'],
                'password'  => $data['password'],
                'role'      => 'dosen',
                'is_active' => true,
            ]);

            $dosen = Dosen::create([
                'user_id'             => $user->id,
                'fakultas_id'         => $data['fakultas_id'],
                'prodi_id'            => $data['prodi_id'],
                'nama_lengkap'        => $data['nama_lengkap'],
                'nidn'                => $data['nidn'] ?? null,
                'nidk'                => $data['nidk'] ?? null,
                'jabatan_fungsional'  => $data['jabatan_fungsional'] ?? null,
                'pangkat_golongan'    => $data['pangkat_golongan'] ?? null,
                'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                'no_hp'               => $data['no_hp'] ?? null,
                'foto_path'           => $fotoPath,
                'scopus_id'           => $data['scopus_id'] ?? null,
                'google_scholar_id'   => $data['google_scholar_id'] ?? null,
                'sinta_id'            => $data['sinta_id'] ?? null,
                'sinta_score'         => $data['sinta_score'] ?? 0,
                'status_aktif_mengajar' => true,
                'is_reviewer'         => false,
            ]);

            if (! empty($data['keahlian_ids'])) {
                $dosen->keahlian()->sync($data['keahlian_ids']);
            }
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login menggunakan NIK ' . $data['nik'] . '.');
    }
}
