<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class UserForm extends Component
{
    public $params = array();

    public function mount($local) {
        $this->params = session('params');
        $this->params['_local'] = $local;
    }
    
    public function render()
    {
        return view('livewire.user-form');
    }
}
