<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Transaction\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $modul = $request->get('modul', '');
        $q     = trim($request->get('q', ''));

        $log = LogAktivitas::with('user:id,nik,username,role')
            ->when($modul, fn($query) => $query->where('modul', $modul))
            ->when($q, fn($query) => $query->where(function ($w) use ($q) {
                $w->where('aktivitas', 'like', "%{$q}%")
                  ->orWhere('deskripsi', 'like', "%{$q}%")
                  ->orWhereHas('user', fn($u) => $u->where('nik', 'like', "%{$q}%")->orWhere('username', 'like', "%{$q}%"));
            }))
            ->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();

        $modulList = LogAktivitas::select('modul')->distinct()->orderBy('modul')->pluck('modul');

        return view('operator.log.index', compact('log', 'modulList', 'modul', 'q'));
    }
}
