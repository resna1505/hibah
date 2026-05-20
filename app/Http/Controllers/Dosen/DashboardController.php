<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dosen.dashboard', [
            'user' => $request->user(),
            'dosen' => $request->user()->dosen,
        ]);
    }
}
