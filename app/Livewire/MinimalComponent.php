<?php

namespace App\Livewire;

use Livewire\Component;

class MinimalComponent extends Component
{
    public $message = 'Hello, Livewire!';

    public function updateMessage()
    {
        $this->message = 'Mensagem atualizada!';
    }

    public function render()
    {
        return view('livewire.minimal-component');
    }
}
