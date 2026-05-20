<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $nik = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'nik' => 'required|string|max:30',
        'password' => 'required|string|min:6',
    ];

    protected array $messages = [
        'nik.required' => 'NIK wajib diisi.',
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
            'nik' => $this->nik,
            'password' => $this->password,
            'is_active' => true,
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('nik', 'NIK atau password salah.');
            return null;
        }

        Auth::user()->forceFill(['last_login_at' => now()])->save();

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
