<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Penjaga kebijakan blind review.
 *
 * LPPM menetapkan reviewer menilai tanpa mengetahui identitas pengusul — nama,
 * NIDN, program studi, fakultas, maupun nama anggota. Test ini menahan agar
 * identitas tersebut tidak diam-diam masuk kembali ke permukaan reviewer saat
 * ada perubahan di kemudian hari.
 *
 * Yang diperiksa hanya berkas di bawah namespace/direktori reviewer. Identitas
 * reviewer itu sendiri (`$dosen`, profilnya) tetap boleh tampil.
 */
class BlindReviewTest extends TestCase
{
    /** Direktori yang menjadi permukaan reviewer. */
    private const SCAN = [
        'resources/views/reviewer',
        'app/Http/Controllers/Reviewer',
    ];

    /** Pola yang tidak boleh muncul sama sekali — semuanya identitas pengusul. */
    private const TERLARANG = [
        '/->ketua\b/'         => 'relasi ketua pengusul',
        '/proposal\.ketua/'   => 'eager-load proposal.ketua',
        '/\bnama_mahasiswa\b/'=> 'nama anggota mahasiswa',
        '/\bpimpinan_mitra\b/'=> 'nama pimpinan mitra',
        '/\bttd_path\b/'      => 'tanda tangan pengusul',
    ];

    /**
     * Pola yang hanya boleh dipakai untuk data reviewer yang sedang login,
     * yaitu bila pada baris yang sama terdapat variabel `$dosen`.
     */
    private const HANYA_MILIK_SENDIRI = [
        '/\bnama_lengkap\b/' => 'nama',
        '/\bnidn\b/'         => 'NIDN',
        '/\bsinta_/'         => 'data Sinta',
    ];

    public function test_permukaan_reviewer_tidak_memuat_identitas_pengusul(): void
    {
        $pelanggaran = [];

        foreach ($this->berkasTerpindai() as $path) {
            foreach (file($path) as $i => $baris) {
                $noBaris = $i + 1;
                $relatif = str_replace(base_path() . '/', '', $path);

                // Komentar tidak dieksekusi, jadi tidak membocorkan apa pun.
                if ($this->adalahKomentar($baris)) {
                    continue;
                }

                foreach (self::TERLARANG as $pola => $ket) {
                    if (preg_match($pola, $baris)) {
                        $pelanggaran[] = "{$relatif}:{$noBaris} — {$ket}";
                    }
                }

                // Boleh kalau baris itu jelas merujuk ke reviewer yang login.
                if (preg_match('/\$dosen\??->/', $baris)) {
                    continue;
                }

                foreach (self::HANYA_MILIK_SENDIRI as $pola => $ket) {
                    if (preg_match($pola, $baris)) {
                        $pelanggaran[] = "{$relatif}:{$noBaris} — {$ket} di luar konteks reviewer sendiri";
                    }
                }
            }
        }

        $this->assertSame([], $pelanggaran,
            "Identitas pengusul bocor ke halaman reviewer:\n" . implode("\n", $pelanggaran));
    }

    public function test_pdf_reviewer_memakai_template_tanpa_identitas(): void
    {
        $controller = file_get_contents(base_path('app/Http/Controllers/Reviewer/ProposalController.php'));

        $this->assertStringContainsString("Pdf::loadView('reviewer.pdf-proposal'", $controller,
            'PDF reviewer harus memakai template blind, bukan template lengkap milik dosen.');

        foreach (['dosen.penelitian.pdf', 'dosen.pkm.pdf'] as $templateDosen) {
            $this->assertStringNotContainsString($templateDosen, $controller,
                "Template dosen {$templateDosen} memuat identitas & tanda tangan, tidak boleh dipakai reviewer.");
        }

        $this->assertFileExists(base_path('resources/views/reviewer/pdf-proposal.blade.php'));
    }

    public function test_reviewer_tidak_bisa_mencari_proposal_berdasarkan_nama_dosen(): void
    {
        $controller = file_get_contents(base_path('app/Http/Controllers/Reviewer/ProposalController.php'));

        $this->assertStringNotContainsString('nama_lengkap', $controller,
            'Pencarian berdasarkan nama dosen membocorkan identitas yang sedang disamarkan.');
    }

    /** @return list<string> */
    private function berkasTerpindai(): array
    {
        $hasil = [];

        foreach (self::SCAN as $dir) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(base_path($dir), \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isFile() && in_array($file->getExtension(), ['php'], true)) {
                    // Halaman profil reviewer memang menampilkan datanya sendiri.
                    if (str_contains($file->getPathname(), '/profil/')) {
                        continue;
                    }
                    $hasil[] = $file->getPathname();
                }
            }
        }

        sort($hasil);

        return $hasil;
    }

    private function adalahKomentar(string $baris): bool
    {
        $trim = ltrim($baris);

        return str_starts_with($trim, '//')
            || str_starts_with($trim, '*')
            || str_starts_with($trim, '/*')
            || str_starts_with($trim, '{{--');
    }
}
