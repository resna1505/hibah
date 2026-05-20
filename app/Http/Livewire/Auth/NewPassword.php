<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewPassword extends Component
{
    public $email;
    public $token;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'password' => 'required|string|min:8|confirmed'
    ];

   public function mount($email, $token){
       $this->email = $email;
       $this->token = $token;
   }

    public function resetPassword() {
        $this->validate();

        if($this->email != null && $this->token != null) {
            User::where('email', $this->email)->where('remember_token', $this->token)->update([
                'password' => Hash::make($this->password)
            ]);
            return redirect('/login')->with('success', 'Your password has been reseted.!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function render()
    {
        return view('livewire.auth.new-password')->extends('layouts.master-without-nav');
    }
}
