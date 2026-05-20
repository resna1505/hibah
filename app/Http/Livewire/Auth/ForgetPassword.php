<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;

class ForgetPassword extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function submit()
    {
        $this->validate([
            'email' => 'required|email',
        ]);
        
        $user = User::where('email', $this->email)->first();
        if ($user && $user->remember_token) {
            $forgetUrl = url('/').'/new-password'."/".$user->email."/".$user->remember_token;

            try {
                Mail::to($user->email)->send(new ResetPasswordEmail($forgetUrl));
                session()->flash('success', 'Forget password link sent to your email address. Please check your email.');
            } catch (\Exception $e) {
                session()->flash('error', 'Email was not sent. Please contact support for more details.');
            }
        } else {
            $this->addError('email', 'User email not found in our records');
        }
        $this->render();
    }

    public function render()
    {
        return view('livewire.auth.forget-password')->extends('layouts.master-without-nav');
    }
}
