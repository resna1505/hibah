<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\Dosen;
use App\Models\Transaction\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AkunDosenController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $akun = User::where('role', 'dosen')
            ->with('dosen:id,user_id,nama_lengkap,prodi_id,fakultas_id,is_reviewer')
            ->when($q, fn($query) => $query->where(function ($w) use ($q) {
                $w->where('nik', 'like', "%{$q}%")
                  ->orWhere('username', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhereHas('dosen', fn($d) => $d->where('nama_lengkap', 'like', "%{$q}%"));
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('operator.akun-dosen.index', compact('akun', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik'      => 'required|string|max:30|unique:users_m,nik',
            'nama'     => 'required|string|max:200',
            'email'    => 'nullable|email|max:255|unique:users_m,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        DB::transaction(function () use ($data, $request) {
            $user = User::create([
                'nik'       => $data['nik'],
                'username'  => $data['nik'],
                'email'     => $data['email'] ?? null,
                'password'  => $data['password'],
                'role'      => 'dosen',
                'is_active' => true,
            ]);

            Dosen::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $data['nama'],
            ]);

            LogAktivitas::create([
                'user_id'    => $request->user()->id,
                'modul'      => 'akun_dosen',
                'aktivitas'  => 'buat_akun',
                'deskripsi'  => "Membuat akun login dosen NIK {$data['nik']} ({$data['nama']}).",
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Akun dosen untuk NIK {$data['nik']} berhasil dibuat. Sampaikan NIK & password ke dosen yang bersangkutan.");
    }

    public function toggle(Request $request, User $akun)
    {
        abort_unless($akun->role === 'dosen', 403);

        $akun->update(['is_active' => ! $akun->is_active]);

        LogAktivitas::create([
            'user_id'    => $request->user()->id,
            'modul'      => 'akun_dosen',
            'aktivitas'  => $akun->is_active ? 'aktifkan_akun' : 'nonaktifkan_akun',
            'deskripsi'  => ($akun->is_active ? 'Mengaktifkan' : 'Menonaktifkan') . " akun dosen NIK {$akun->nik}.",
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Status akun diperbarui.');
    }

    public function resetPassword(Request $request, User $akun)
    {
        abort_unless($akun->role === 'dosen', 403);

        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $akun->update(['password' => $data['password']]);

        LogAktivitas::create([
            'user_id'    => $request->user()->id,
            'modul'      => 'akun_dosen',
            'aktivitas'  => 'reset_password',
            'deskripsi'  => "Reset password akun dosen NIK {$akun->nik}.",
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return back()->with('success', "Password akun NIK {$akun->nik} berhasil direset.");
    }
}
