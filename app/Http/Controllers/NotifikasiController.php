<?php

namespace App\Http\Controllers;

use App\Models\Transaction\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $filter = $request->filter ?? 'semua';

        $list = Notifikasi::where('user_id', $userId)
            ->when($filter === 'belum_dibaca', fn($q) => $q->whereNull('dibaca_at'))
            ->when($filter === 'sudah_dibaca', fn($q) => $q->whereNotNull('dibaca_at'))
            ->latest()
            ->paginate(20)->withQueryString();

        $stats = [
            'total'         => Notifikasi::where('user_id', $userId)->count(),
            'belum_dibaca'  => Notifikasi::where('user_id', $userId)->whereNull('dibaca_at')->count(),
            'sudah_dibaca'  => Notifikasi::where('user_id', $userId)->whereNotNull('dibaca_at')->count(),
        ];

        return view('notifikasi.index', compact('list', 'stats', 'filter'));
    }

    public function markRead(Request $request, Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->user_id === $request->user()->id, 403);
        $notifikasi->markRead();

        if ($notifikasi->link) {
            return redirect()->to($notifikasi->link);
        }
        return back();
    }

    public function markAllRead(Request $request)
    {
        Notifikasi::where('user_id', $request->user()->id)
            ->whereNull('dibaca_at')
            ->update(['dibaca_at' => now()]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
