<?php

namespace App\Livewire;

use Livewire\Component;

class FormComponent extends Component
{
    //? Parametros vindo do screen-renderer através do click do botão de add
    public $params = array();

    public function mount($local, $icon) {
        //? Recebendo parametros
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );
    }

    public function render()
    {
        return view('livewire.form-component');
    }
}
