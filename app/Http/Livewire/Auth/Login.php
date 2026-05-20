<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = "admin@themesbrand.com";
    public $password = "12345678";

    protected $rules = [
        'email' => 'required|string|email|max:255',
        'password' => 'required',
    ];

   public function mount()
   {
       if (auth()->user()) {
           return redirect()->intended('/');
       }
   }

    public function submit()
    {
        // validate the data
        $this->validate();

        $user = array(
            'email' => $this->email,
            'password' => $this->password,
        );

        if (Auth::attempt($user)) {
            return redirect()->intended('/');
        } else {
            $this->addError('email', trans('auth.failed'));
           return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.master-without-nav');
    }
}
