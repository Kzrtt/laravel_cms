<?php

namespace App\Livewire;

use Livewire\Component;

class ListComponent extends Component
{
    public $params = array();

    public function mount($local, $icon) {
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );
    }


    public function render()
    {
        return view('livewire.list-component', $this->params);
    }
}
