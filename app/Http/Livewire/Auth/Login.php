<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $username = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'username' => 'required|string|max:50',
        'password' => 'required|string|min:6',
    ];

    protected array $messages = [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ];

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirectToRoleHome();
        }
    }

    public function submit()
    {
        $this->validate();

        $credentials = [
            'username' => $this->username,
            'password' => $this->password,
            'is_active' => true,
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('username', 'Username atau password salah.');
            return null;
        }

        Auth::user()->forceFill(['last_login_at' => now()])->save();

        \App\Models\Transaction\LogAktivitas::create([
            'user_id'    => Auth::id(),
            'modul'      => 'auth',
            'aktivitas'  => 'login',
            'deskripsi'  => 'Login berhasil sebagai ' . Auth::user()->role . '.',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);

        session()->regenerate();

        return $this->redirectToRoleHome();
    }

    protected function redirectToRoleHome()
    {
        $user = Auth::user();

        if ($user->isOperator()) {
            return redirect()->intended(route('operator.dashboard'));
        }

        // Dosen (termasuk yang punya flag is_reviewer)
        return redirect()->intended(route('dosen.dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.master-without-nav');
    }
}
