<?php

namespace App\Livewire;

use Livewire\Component;
use App\Controllers\UserCtrl;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions; 

/**
 * Classe para tratamento da rendereização da tela de login e a lógica
 * para armazenar o usuário no helper auth().
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.empty')]
class LoginScreen extends Component
{
    use Interactions;

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
            $this->dialog()
            ->error("Erro no Login", $loginResponse['message'])
            ->send();

            return;
        }

        Auth::login($loginResponse['user']);

        $this->dialog()
        ->success("Usuário Autenticado!", "Redirecionando para Dashboard do sistema.")
        ->send();

        $usrName = auth()->user()->getPerson->pes_name;
        $usrLevel = auth()->user()->getProfile->prf_name;
        $usrRepresentedAgent = getAgentName(auth()->user()->usr_level);

        $this->toast()
        ->success("Autenticado com {$usrLevel}", "{$usrName} representando {$usrRepresentedAgent}")
        ->flash()
        ->send();

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.login-screen');
    }
}
