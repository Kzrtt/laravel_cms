<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

/**
 * Classe para atribuição e remoção das permissões de um usuário
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class PermissionAssignScreen extends Component
{
    public function mount($id) {
        
    }

    public function render()
    {
        return view('livewire.permission-assign-screen');
    }
}
