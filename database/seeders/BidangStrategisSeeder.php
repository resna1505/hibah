<?php

namespace Database\Seeders;

use App\Models\Master\BidangStrategis;
use Illuminate\Database\Seeder;

class BidangStrategisSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 1, 'nama' => 'Pangan', 'deskripsi' => 'Ketahanan dan kemandirian pangan'],
            ['kode' => 2, 'nama' => 'Energi', 'deskripsi' => 'Energi baru dan terbarukan'],
            ['kode' => 3, 'nama' => 'Kesehatan dan Obat', 'deskripsi' => 'Kesehatan masyarakat, obat-obatan, dan teknologi kedokteran'],
            ['kode' => 4, 'nama' => 'Transportasi', 'deskripsi' => 'Sistem transportasi cerdas dan infrastruktur'],
            ['kode' => 5, 'nama' => 'Telekomunikasi, Informasi & Komputer', 'deskripsi' => 'TIK, AI, big data, dan sistem informasi'],
            ['kode' => 6, 'nama' => 'Pertahanan dan Keamanan', 'deskripsi' => 'Teknologi pertahanan, keamanan siber, dan sistem informasi pertahanan'],
            ['kode' => 7, 'nama' => 'Material Maju', 'deskripsi' => 'Material maju, nanoteknologi, dan rekayasa material'],
            ['kode' => 8, 'nama' => 'Hilirisasi dan Industrialisasi', 'deskripsi' => 'Hilirisasi hasil riset, sosial humaniora, ekonomi kreatif, lingkungan, dan pendidikan'],
        ];

        foreach ($data as $row) {
            BidangStrategis::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}
