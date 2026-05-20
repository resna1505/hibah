<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Master\TahapanHibah;
use App\Models\Transaction\JadwalTahapan;
use App\Models\Transaction\PeriodeHibah;
use App\Models\Transaction\PeriodeLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $list = PeriodeHibah::withCount(['jadwalTahapan', 'proposal'])
            ->orderByDesc('tahun')
            ->paginate(15)->withQueryString();

        return view('operator.jadwal.index', compact('list'));
    }

    public function create(Request $request)
    {
        return view('operator.jadwal.form', [
            'periode'         => null,
            'tahapanHibah'    => TahapanHibah::orderBy('urutan')->get(),
            'jadwalByKode'    => collect(),
            'periodeLaporan'  => collect(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun'      => 'required|integer|min:2020|max:2100|unique:periode_hibah_t,tahun',
            'nama'       => 'required|string|max:150',
            'status'     => 'required|in:draft,aktif,selesai',
            'keterangan' => 'nullable|string|max:1000',

            // Jadwal tahapan (6 baris fixed)
            'tahapan_id' => 'required|array',
            'tgl_mulai'  => 'required|array',
            'tgl_selesai'=> 'required|array',
            'tahapan_status' => 'required|array',

            // Periode laporan (dynamic add per skema)
            'laporan_skema' => 'array',
            'laporan_label' => 'array',
            'laporan_batas' => 'array',
        ], [
            'tahun.unique' => 'Sudah ada periode hibah untuk tahun tersebut.',
        ]);

        $periode = DB::transaction(function () use ($data) {
            // Kalau status=aktif, non-aktifkan periode lain
            if ($data['status'] === 'aktif') {
                PeriodeHibah::where('status', 'aktif')->update(['status' => 'selesai']);
            }

            $periode = PeriodeHibah::create([
                'tahun'      => $data['tahun'],
                'nama'       => $data['nama'],
                'status'     => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $this->syncJadwalTahapan($periode, $data);
            $this->syncPeriodeLaporan($periode, $data);

            return $periode;
        });

        return redirect()->route('operator.jadwal.edit', $periode)
            ->with('success', "Periode '{$periode->nama}' berhasil dibuat.");
    }

    public function edit(Request $request, PeriodeHibah $jadwal)
    {
        $tahapanHibah = TahapanHibah::orderBy('urutan')->get();
        $jadwalByKode = $jadwal->jadwalTahapan()->with('tahapanHibah')->get()
            ->keyBy(fn($j) => $j->tahapanHibah->kode);
        $periodeLaporan = $jadwal->periodeLaporan()->orderBy('skema_jenis')->orderBy('urutan')->get();

        return view('operator.jadwal.form', [
            'periode'        => $jadwal,
            'tahapanHibah'   => $tahapanHibah,
            'jadwalByKode'   => $jadwalByKode,
            'periodeLaporan' => $periodeLaporan,
        ]);
    }

    public function update(Request $request, PeriodeHibah $jadwal)
    {
        $data = $request->validate([
            'tahun'      => 'required|integer|min:2020|max:2100|unique:periode_hibah_t,tahun,' . $jadwal->id,
            'nama'       => 'required|string|max:150',
            'status'     => 'required|in:draft,aktif,selesai',
            'keterangan' => 'nullable|string|max:1000',

            'tahapan_id' => 'required|array',
            'tgl_mulai'  => 'required|array',
            'tgl_selesai'=> 'required|array',
            'tahapan_status' => 'required|array',

            'laporan_skema' => 'array',
            'laporan_label' => 'array',
            'laporan_batas' => 'array',
        ]);

        DB::transaction(function () use ($data, $jadwal) {
            if ($data['status'] === 'aktif') {
                PeriodeHibah::where('id', '!=', $jadwal->id)
                    ->where('status', 'aktif')->update(['status' => 'selesai']);
            }

            $jadwal->update([
                'tahun'      => $data['tahun'],
                'nama'       => $data['nama'],
                'status'     => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $this->syncJadwalTahapan($jadwal, $data);
            $this->syncPeriodeLaporan($jadwal, $data);
        });

        return back()->with('success', 'Jadwal periode diperbarui.');
    }

    public function activate(Request $request, PeriodeHibah $jadwal)
    {
        DB::transaction(function () use ($jadwal) {
            PeriodeHibah::where('id', '!=', $jadwal->id)
                ->where('status', 'aktif')->update(['status' => 'selesai']);
            $jadwal->update(['status' => 'aktif']);
        });

        return back()->with('success', "Periode '{$jadwal->nama}' kini aktif.");
    }

    public function destroy(Request $request, PeriodeHibah $jadwal)
    {
        if ($jadwal->proposal()->exists()) {
            return back()->with('error', 'Periode tidak dapat dihapus karena sudah ada proposal.');
        }

        $jadwal->delete();
        return redirect()->route('operator.jadwal.index')->with('success', 'Periode dihapus.');
    }

    private function syncJadwalTahapan(PeriodeHibah $periode, array $data): void
    {
        $periode->jadwalTahapan()->delete();

        foreach ($data['tahapan_id'] as $i => $tahapanId) {
            JadwalTahapan::create([
                'periode_hibah_id'  => $periode->id,
                'tahapan_hibah_id'  => $tahapanId,
                'tgl_mulai'         => $data['tgl_mulai'][$i],
                'tgl_selesai'       => $data['tgl_selesai'][$i],
                'status'            => $data['tahapan_status'][$i] ?? 'belum_mulai',
            ]);
        }
    }

    private function syncPeriodeLaporan(PeriodeHibah $periode, array $data): void
    {
        $periode->periodeLaporan()->delete();

        $skemaArr = $data['laporan_skema'] ?? [];
        $labelArr = $data['laporan_label'] ?? [];
        $batasArr = $data['laporan_batas'] ?? [];

        $countByJenis = ['penelitian' => 0, 'pkm' => 0];

        foreach ($skemaArr as $i => $skema) {
            if (! in_array($skema, ['penelitian', 'pkm'])) continue;
            $label = trim($labelArr[$i] ?? '');
            $batas = $batasArr[$i] ?? null;
            if (! $label || ! $batas) continue;

            $countByJenis[$skema]++;

            PeriodeLaporan::create([
                'periode_hibah_id' => $periode->id,
                'skema_jenis'      => $skema,
                'urutan'           => $countByJenis[$skema],
                'label'            => $label,
                'batas_unggah'     => $batas,
            ]);
        }
    }
}
