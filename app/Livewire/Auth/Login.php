<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function fillAccount($email)
    {
        $this->email = $email;
        $this->password = 'password';
    }

    public function quickLogin($email)
    {
        $this->email = $email;
        $this->password = 'password';
        $this->login();
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.app', ['title' => 'Login - Internal IT Ticket Dashboard']);
    }
}
