<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FakultasSeeder::class,
            ProdiSeeder::class,
            KeahlianSeeder::class,
            SkemaHibahSeeder::class,
            TahapanHibahSeeder::class,
            KriteriaPenilaianSeeder::class,
            JenisLuaranSeeder::class,
            KategoriRabSeeder::class,
            UserDosenSeeder::class,
            PeriodeHibahSeeder::class,
            ProposalDummySeeder::class,
        ]);
    }
}
