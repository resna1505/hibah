<?php

namespace Database\Seeders;

use App\Models\Master\Dosen;
use App\Models\Master\Fakultas;
use App\Models\Master\Keahlian;
use App\Models\Master\Prodi;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserDosenSeeder extends Seeder
{
    public function run(): void
    {
        // Operator LPPM
        $operator = User::updateOrCreate(
            ['nik' => 'OPR001'],
            [
                'username' => 'operator',
                'email'    => 'operator@univbatam.ac.id',
                'password' => 'password',
                'role'     => 'operator',
                'is_active'=> true,
            ]
        );

        // Dummy dosen — sebagian flagged sebagai reviewer
        $dosenData = [
            [
                'nik' => '198501012010011001',
                'nama' => 'Dr. Andi Saputra, S.T., M.Kom',
                'nidn' => '1025038801', 'fakultas' => 'FIK', 'prodi' => 'SI',
                'jabatan' => 'Lektor', 'pangkat' => 'III/c', 'pendidikan' => 'S3',
                'no_hp' => '081234567890', 'sinta_score' => 1056, 'is_reviewer' => true,
                'keahlian' => ['Sistem Informasi', 'Rekayasa Perangkat Lunak', 'Basis Data'],
            ],
            [
                'nik' => '198003152008012002',
                'nama' => 'Nia Karneli, S.Pd., M.Pd.',
                'nidn' => '1015038002', 'fakultas' => 'FKIP', 'prodi' => 'PBI',
                'jabatan' => 'Lektor', 'pangkat' => 'III/c', 'pendidikan' => 'S2',
                'no_hp' => '081234567891', 'sinta_score' => 820, 'is_reviewer' => true,
                'keahlian' => ['Pendidikan', 'E-Learning'],
            ],
            [
                'nik' => '197505102005012003',
                'nama' => 'Ir. Desi Karina, M.T.',
                'nidn' => '1010057503', 'fakultas' => 'FT', 'prodi' => 'TL',
                'jabatan' => 'Lektor Kepala', 'pangkat' => 'IV/a', 'pendidikan' => 'S3',
                'no_hp' => '081234567892', 'sinta_score' => 1340, 'is_reviewer' => true,
                'keahlian' => ['Energi Terbarukan', 'Teknik Lingkungan'],
            ],
            [
                'nik' => '198209252011012004',
                'nama' => 'Dr. Welly Sugianto, S.E., M.M.',
                'nidn' => '1025098204', 'fakultas' => 'FE', 'prodi' => 'MJ',
                'jabatan' => 'Lektor', 'pangkat' => 'III/d', 'pendidikan' => 'S3',
                'no_hp' => '081234567893', 'sinta_score' => 980, 'is_reviewer' => true,
                'keahlian' => ['Manajemen', 'Kewirausahaan', 'Pemasaran Digital'],
            ],
            [
                'nik' => '199001152015011005',
                'nama' => 'Raymond, S.E., M.M.',
                'nidn' => '1015019005', 'fakultas' => 'FE', 'prodi' => 'MJ',
                'jabatan' => 'Lektor', 'pangkat' => 'III/c', 'pendidikan' => 'S2',
                'no_hp' => '081234567894', 'sinta_score' => 540, 'is_reviewer' => false,
                'keahlian' => ['Manajemen', 'Kewirausahaan'],
            ],
            [
                'nik' => '199203202016012006',
                'nama' => 'Rina Asmara, S.E., M.Ak.',
                'nidn' => '1020039206', 'fakultas' => 'FE', 'prodi' => 'AK',
                'jabatan' => 'Asisten Ahli', 'pangkat' => 'III/b', 'pendidikan' => 'S2',
                'no_hp' => '081234567895', 'sinta_score' => 380, 'is_reviewer' => false,
                'keahlian' => ['Akuntansi', 'Keuangan'],
            ],
            [
                'nik' => '197812052003011007',
                'nama' => 'Dr. Muhammad Ikhsan',
                'nidn' => '1005127807', 'fakultas' => 'FT', 'prodi' => 'TS',
                'jabatan' => 'Lektor Kepala', 'pangkat' => 'IV/a', 'pendidikan' => 'S3',
                'no_hp' => '081234567896', 'sinta_score' => 1480, 'is_reviewer' => true,
                'keahlian' => ['Teknik Sipil', 'Struktur'],
            ],
        ];

        foreach ($dosenData as $row) {
            $user = User::updateOrCreate(
                ['nik' => $row['nik']],
                [
                    'username' => strtolower(explode(',', $row['nama'])[0]),
                    'email'    => $this->emailFromNik($row['nik']),
                    'password' => 'password',
                    'role'     => 'dosen',
                    'is_active'=> true,
                ]
            );

            $fakultas = Fakultas::where('kode', $row['fakultas'])->firstOrFail();
            $prodi    = Prodi::where('kode', $row['prodi'])->firstOrFail();

            $dosen = Dosen::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'fakultas_id' => $fakultas->id,
                    'prodi_id'    => $prodi->id,
                    'nama_lengkap'=> $row['nama'],
                    'nidn'        => $row['nidn'],
                    'jabatan_fungsional'  => $row['jabatan'],
                    'pangkat_golongan'    => $row['pangkat'],
                    'pendidikan_terakhir' => $row['pendidikan'],
                    'no_hp'       => $row['no_hp'],
                    'sinta_score' => $row['sinta_score'],
                    'status_aktif_mengajar' => true,
                    'is_reviewer' => $row['is_reviewer'],
                ]
            );

            $keahlianIds = Keahlian::whereIn('nama', $row['keahlian'])->pluck('id')->all();
            $dosen->keahlian()->sync($keahlianIds);
        }
    }

    private function emailFromNik(string $nik): string
    {
        return 'dosen' . substr($nik, -4) . '@univbatam.ac.id';
    }
}
