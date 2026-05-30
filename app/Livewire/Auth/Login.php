<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.auth')]
class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

public function login()
{
    $this->validate();

    if (Auth::attempt([
        'email' => $this->email,
        'password' => $this->password
    ])) {

        session()->regenerate();

        $user = auth()->user();

        // Operator otomatis memakai SKPD miliknya
        if ($user->role === 'operator_skpd') {

            session([
                'active_skpd_id' => $user->skpd_id
            ]);

        } else {

            // Admin / Viewer default SKPD pertama
            session([
                'active_skpd_id' => session('active_skpd_id', 1)
            ]);
        }

        return redirect()->intended('/dashboard');
    }

    $this->addError('email', 'Email atau password salah');
}

    public function render()
    {
        return view('livewire.auth.login');
    }
}
