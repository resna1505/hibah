<?php

use App\Http\Controllers\Dosen\DashboardController as DosenDashboard;
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
    });

    /*
    |----- Reviewer (dosen dengan is_reviewer=true) -----
    */
    Route::middleware('role:reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/dashboard', [ReviewerDashboard::class, 'index'])->name('dashboard');
    });
});
