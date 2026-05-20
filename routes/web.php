<?php

use App\Http\Controllers\Dosen\DashboardController as DosenDashboard;
use App\Http\Controllers\Dosen\ProfilController as DosenProfil;
use App\Http\Controllers\Dosen\RiwayatHkiController as DosenRiwayatHki;
use App\Http\Controllers\Dosen\RiwayatPenelitianController as DosenRiwayatPenelitian;
use App\Http\Controllers\Dosen\RiwayatPkmController as DosenRiwayatPkm;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboard;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes (login/register/reset)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::post('/login', \App\Http\Livewire\Auth\Login::class)->name('login.post');
    Route::get('/register', \App\Http\Livewire\Auth\Register::class)->name('register');
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
    });

    /*
    |----- Reviewer (dosen dengan is_reviewer=true) -----
    */
    Route::middleware('role:reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/dashboard', [ReviewerDashboard::class, 'index'])->name('dashboard');
    });
});
