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
            ->with('dosen:id,user_id,nama_lengkap,prodi_id,fakultas_id,is_reviewer,is_ketua_eligible')
            ->when($q, fn($query) => $query->where(function ($w) use ($q) {
                $w->where('username', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhereHas('dosen', fn($d) => $d->where('nama_lengkap', 'like', "%{$q}%")
                                                    ->orWhere('nidn', 'like', "%{$q}%"));
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('operator.akun-dosen.index', compact('akun', 'q'));
    }

    /**
     * Tampilkan biodata lengkap dosen (read-only) untuk operator.
     */
    public function biodata(Request $request, User $akun)
    {
        abort_unless($akun->role === 'dosen', 403);

        $dosen = $akun->dosen;
        $dosen?->load(['fakultas', 'prodi', 'keahlian']);

        $riwayatPenelitian = $dosen
            ? $dosen->riwayatPenelitian()->orderByDesc('tahun')->get()
            : collect();
        $riwayatPkm = $dosen
            ? $dosen->riwayatPkm()->orderByDesc('tahun')->get()
            : collect();
        $riwayatHki = $dosen
            ? $dosen->riwayatHki()->orderByDesc('tahun_pengajuan')->get()
            : collect();

        return view('operator.akun-dosen.biodata', [
            'akun'              => $akun,
            'dosen'             => $dosen,
            'riwayatPenelitian' => $riwayatPenelitian,
            'riwayatPkm'        => $riwayatPkm,
            'riwayatHki'        => $riwayatHki,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nidn'     => 'required|string|max:20|unique:dosen_m,nidn|unique:users_m,nik',
            'username' => 'required|string|max:50|alpha_dash|unique:users_m,username',
            'nama'     => 'required|string|max:200',
            'email'    => 'nullable|email|max:255|unique:users_m,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip (-), dan underscore (_).',
            'nidn.unique'         => 'NIDN sudah terdaftar.',
        ]);

        DB::transaction(function () use ($data, $request) {
            // users_m.nik wajib + unique. Kita pakai NIDN sebagai nilai NIK karena untuk dosen,
            // NIDN adalah identitas resmi yang dijamin unik.
            $user = User::create([
                'nik'       => $data['nidn'],
                'username'  => $data['username'],
                'email'     => $data['email'] ?? null,
                'password'  => $data['password'],
                'role'      => 'dosen',
                'is_active' => true,
            ]);

            Dosen::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $data['nama'],
                'nidn'         => $data['nidn'],
            ]);

            LogAktivitas::create([
                'user_id'    => $request->user()->id,
                'modul'      => 'akun_dosen',
                'aktivitas'  => 'buat_akun',
                'deskripsi'  => "Membuat akun login dosen NIDN {$data['nidn']} ({$data['nama']}).",
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Akun dosen NIDN {$data['nidn']} berhasil dibuat. Sampaikan username '{$data['username']}' & password ke dosen yang bersangkutan.");
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

    /**
     * Tetapkan / cabut hak dosen menjadi ketua pengusul.
     */
    public function toggleKetua(Request $request, User $akun)
    {
        abort_unless($akun->role === 'dosen', 403);

        $dosen = $akun->dosen;
        abort_unless($dosen, 404, 'Akun belum terhubung dengan profil dosen.');

        $dosen->update(['is_ketua_eligible' => ! $dosen->is_ketua_eligible]);

        LogAktivitas::create([
            'user_id'    => $request->user()->id,
            'modul'      => 'akun_dosen',
            'aktivitas'  => $dosen->is_ketua_eligible ? 'tetapkan_ketua' : 'cabut_ketua',
            'deskripsi'  => ($dosen->is_ketua_eligible ? 'Menetapkan' : 'Mencabut') . " hak ketua pengusul untuk {$dosen->nama_lengkap}.",
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        $msg = $dosen->is_ketua_eligible
            ? "{$dosen->nama_lengkap} sekarang boleh menjadi ketua pengusul."
            : "{$dosen->nama_lengkap} tidak lagi boleh menjadi ketua pengusul.";

        return back()->with('success', $msg);
    }
}
