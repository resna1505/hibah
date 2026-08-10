<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Pemulihan baris tabel berulang (repeater) dari old input.
 *
 * Field skalar pada form usulan sudah memakai old(), tetapi tabel berulang
 * (anggota, mahasiswa, mitra, RAB, rencana luaran, jadwal) semula selalu
 * di-render ulang dari database. Akibatnya satu error validasi apa pun membuat
 * seluruh baris yang baru diketik dosen hilang tanpa jejak, dan dari sisi
 * pengguna terbaca sebagai "data yang sudah diisi tidak bisa disimpan".
 */
class OldInput
{
    /**
     * Bangun ulang baris repeater dari old input.
     *
     * @param  string  $probe  Nama field penanda — jumlah elemennya menentukan jumlah baris.
     * @param  array<string,string>  $map  Nama properti hasil => nama field pada request.
     * @return Collection<int,object>|null  null bila tidak ada old input, sehingga
     *                                      pemanggil tetap merender dari database.
     */
    public static function rows(string $probe, array $map): ?Collection
    {
        $probeValue = old($probe);

        if ($probeValue === null) {
            return null;
        }

        return collect(array_keys((array) $probeValue))->map(
            fn ($i) => (object) collect($map)->map(fn ($field) => old("{$field}.{$i}"))->all()
        );
    }
}
