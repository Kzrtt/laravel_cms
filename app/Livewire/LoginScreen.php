<?php

namespace App\Livewire;

use Livewire\Component;
use App\Controllers\UserCtrl;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.empty')]
class LoginScreen extends Component
{
    public $loginForm = array(
        "email" => "",
        "password" => "",
    );

    public function submitLogin() {
        $userCtrl = new UserCtrl();

        $loginResponse = $userCtrl->validateLogin(
            $this->loginForm['email'],
            $this->loginForm['password'],
        );

        if(!$loginResponse['status']) {
            $this->dispatch(
                'alert', icon: "error", 
                title: "Erro no Login", 
                text:  $loginResponse['message'],
                position: "center"
            );
            return;
        }

        Auth::login($loginResponse['user']);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.login-screen');
    }
}
