<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

/**
 * Classe para tratamento da rendereização da tela de perfil de usuário
 * assim como a manipulação dos dados referentes a ele.
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class ProfileScreen extends Component
{
    public function loggout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.profile-screen');
    }
}
