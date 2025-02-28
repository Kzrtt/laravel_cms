<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ScreenRenderer extends Component
{
    public $view = "livewire.dashboard";
    public $params = array();

    public const MODE_LIST = "list";

    #[On('changeScreen')]
    public function updateView($mode, $local) {        
        switch ($mode) {
            case $this::MODE_LIST:
                $this->view = "livewire.list-component";
                $this->params = array(
                    "_local" => $local,
                );
                break;
            default:
                $this->view = "livewire.dashboard";
        }
    }

    public function render()
    {
        return view($this->view, $this->params);
    }
}
