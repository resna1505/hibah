<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboard;
use App\Http\Controllers\Dosen\LaporanController as DosenLaporan;
use App\Http\Controllers\Dosen\Penelitian\UsulanController as DosenPenelitianUsulan;
use App\Http\Controllers\Dosen\Pengabdian\UsulanController as DosenPkmUsulan;
use App\Http\Controllers\Dosen\ProfilController as DosenProfil;
use App\Http\Controllers\Dosen\RiwayatHkiController as DosenRiwayatHki;
use App\Http\Controllers\Dosen\RiwayatPenelitianController as DosenRiwayatPenelitian;
use App\Http\Controllers\Dosen\RiwayatPkmController as DosenRiwayatPkm;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboard;
use App\Http\Controllers\Operator\PenilaianController as OperatorPenilaian;
use App\Http\Controllers\Operator\ProposalController as OperatorProposal;
use App\Http\Controllers\Operator\ReviewerController as OperatorReviewer;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboard;
use App\Http\Controllers\Reviewer\HasilReviewController as ReviewerHasil;
use App\Http\Controllers\Reviewer\JadwalReviewController as ReviewerJadwal;
use App\Http\Controllers\Reviewer\PenilaianController as ReviewerPenilaian;
use App\Http\Controllers\Reviewer\ProposalController as ReviewerProposal;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes (login/register/reset)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::post('/login', \App\Http\Livewire\Auth\Login::class)->name('login.post');

    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/forget-password', \App\Http\Livewire\Auth\ForgetPassword::class)->name('password.reset');
    Route::get('/new-password/{email?}/{token?}', \App\Http\Livewire\Auth\NewPassword::class);
});

/*
|--------------------------------------------------------------------------
| Bahasa Switcher
|--------------------------------------------------------------------------
*/
Route::get('index/{locale}', [HomeController::class, 'lang']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

    // Root redirect berdasarkan role
    Route::get('/', function () {
        $user = auth()->user();
        if ($user->isOperator()) {
            return redirect()->route('operator.dashboard');
        }
        return redirect()->route('dosen.dashboard');
    });

    /*
    |----- Operator -----
    */
    Route::middleware('role:operator')->prefix('operator')->name('operator.')->group(function () {
        Route::get('/dashboard', [OperatorDashboard::class, 'index'])->name('dashboard');

        // Proposal
        Route::prefix('proposal')->name('proposal.')->group(function () {
            Route::get('/',                       [OperatorProposal::class, 'index'])->name('index');
            Route::get('/{proposal}',             [OperatorProposal::class, 'show'])->name('show');
            Route::get('/{proposal}/verifikasi',  [OperatorProposal::class, 'verifikasiForm'])->name('verifikasi');
            Route::post('/{proposal}/verifikasi', [OperatorProposal::class, 'submitVerifikasi'])->name('verifikasi.submit');
        });

        // Reviewer
        Route::prefix('reviewer')->name('reviewer.')->group(function () {
            Route::get('/data',                  [OperatorReviewer::class, 'dataIndex'])->name('data');
            Route::patch('/data/{dosen}/toggle', [OperatorReviewer::class, 'toggleReviewer'])->name('toggle');
            Route::get('/penugasan',             [OperatorReviewer::class, 'penugasanIndex'])->name('penugasan');
            Route::get('/penugasan/{proposal}',  [OperatorReviewer::class, 'assignForm'])->name('assign.form');
            Route::post('/penugasan/{proposal}', [OperatorReviewer::class, 'assignSubmit'])->name('assign.submit');
            Route::get('/monitoring',            [OperatorReviewer::class, 'monitoringIndex'])->name('monitoring');
        });

        // Penilaian (finalize keputusan akhir)
        Route::prefix('penilaian')->name('penilaian.')->group(function () {
            Route::get('/',                     [OperatorPenilaian::class, 'index'])->name('index');
            Route::get('/{proposal}',           [OperatorPenilaian::class, 'show'])->name('show');
            Route::post('/{proposal}/finalize', [OperatorPenilaian::class, 'finalize'])->name('finalize');
        });
    });

    /*
    |----- Dosen -----
    */
    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenDashboard::class, 'index'])->name('dashboard');

        // Profil
        Route::get('/profil',           [DosenProfil::class, 'edit'])->name('profil.edit');
        Route::put('/profil',           [DosenProfil::class, 'update'])->name('profil.update');
        Route::put('/profil/password',  [DosenProfil::class, 'updatePassword'])->name('profil.password');

        // Riwayat Penelitian
        Route::prefix('riwayat/penelitian')->name('riwayat.penelitian.')->group(function () {
            Route::get('/',                       [DosenRiwayatPenelitian::class, 'index'])->name('index');
            Route::post('/',                      [DosenRiwayatPenelitian::class, 'store'])->name('store');
            Route::delete('/{riwayat_penelitian}',[DosenRiwayatPenelitian::class, 'destroy'])->name('destroy');
        });

        // Riwayat PKM
        Route::prefix('riwayat/pkm')->name('riwayat.pkm.')->group(function () {
            Route::get('/',                [DosenRiwayatPkm::class, 'index'])->name('index');
            Route::post('/',               [DosenRiwayatPkm::class, 'store'])->name('store');
            Route::delete('/{riwayat_pkm}',[DosenRiwayatPkm::class, 'destroy'])->name('destroy');
        });

        // Riwayat HKI
        Route::prefix('riwayat/hki')->name('riwayat.hki.')->group(function () {
            Route::get('/',                [DosenRiwayatHki::class, 'index'])->name('index');
            Route::post('/',               [DosenRiwayatHki::class, 'store'])->name('store');
            Route::delete('/{riwayat_hki}',[DosenRiwayatHki::class, 'destroy'])->name('destroy');
        });

        // Usulan Penelitian
        Route::prefix('penelitian')->name('penelitian.')->group(function () {
            Route::get('/',                       [DosenPenelitianUsulan::class, 'index'])->name('index');
            Route::get('/create',                 [DosenPenelitianUsulan::class, 'create'])->name('create');
            Route::post('/',                      [DosenPenelitianUsulan::class, 'store'])->name('store');
            Route::get('/{penelitian}',           [DosenPenelitianUsulan::class, 'show'])->name('show');
            Route::get('/{penelitian}/edit',      [DosenPenelitianUsulan::class, 'edit'])->name('edit');
            Route::put('/{penelitian}',           [DosenPenelitianUsulan::class, 'update'])->name('update');
            Route::post('/{penelitian}/submit',   [DosenPenelitianUsulan::class, 'submit'])->name('submit');
            Route::delete('/{penelitian}',        [DosenPenelitianUsulan::class, 'destroy'])->name('destroy');
            Route::get('/{penelitian}/pdf',       [DosenPenelitianUsulan::class, 'pdf'])->name('pdf');
        });

        // Usulan PKM
        Route::prefix('pkm')->name('pkm.')->group(function () {
            Route::get('/',                [DosenPkmUsulan::class, 'index'])->name('index');
            Route::get('/create',          [DosenPkmUsulan::class, 'create'])->name('create');
            Route::post('/',               [DosenPkmUsulan::class, 'store'])->name('store');
            Route::get('/{pkm}',           [DosenPkmUsulan::class, 'show'])->name('show');
            Route::get('/{pkm}/edit',      [DosenPkmUsulan::class, 'edit'])->name('edit');
            Route::put('/{pkm}',           [DosenPkmUsulan::class, 'update'])->name('update');
            Route::post('/{pkm}/submit',   [DosenPkmUsulan::class, 'submit'])->name('submit');
            Route::delete('/{pkm}',        [DosenPkmUsulan::class, 'destroy'])->name('destroy');
            Route::get('/{pkm}/pdf',       [DosenPkmUsulan::class, 'pdf'])->name('pdf');
        });

        // Laporan (Penelitian & PKM)
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/{proposal}',                [DosenLaporan::class, 'show'])->name('show');
            Route::post('/{proposal}/kemajuan',      [DosenLaporan::class, 'uploadKemajuan'])->name('kemajuan');
            Route::post('/{proposal}/akhir',         [DosenLaporan::class, 'uploadAkhir'])->name('akhir');
            Route::post('/{proposal}/luaran',        [DosenLaporan::class, 'uploadLuaran'])->name('luaran');
        });
    });

    /*
    |----- Reviewer (dosen dengan is_reviewer=true) -----
    */
    Route::middleware('role:reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/dashboard', [ReviewerDashboard::class, 'index'])->name('dashboard');

        // Proposal (list + detail)
        Route::prefix('proposal')->name('proposal.')->group(function () {
            Route::get('/',            [ReviewerProposal::class, 'index'])->name('index');
            Route::get('/{proposal}',  [ReviewerProposal::class, 'show'])->name('show');
        });

        // Penilaian form + submit
        Route::prefix('penilaian')->name('penilaian.')->group(function () {
            Route::get('/{penugasan}',   [ReviewerPenilaian::class, 'form'])->name('form');
            Route::post('/{penugasan}',  [ReviewerPenilaian::class, 'submit'])->name('submit');
        });

        // Hasil Review
        Route::prefix('hasil')->name('hasil.')->group(function () {
            Route::get('/',              [ReviewerHasil::class, 'index'])->name('index');
            Route::get('/{penugasan}',   [ReviewerHasil::class, 'show'])->name('show');
        });

        // Jadwal Review
        Route::get('/jadwal', [ReviewerJadwal::class, 'index'])->name('jadwal');
    });
});
