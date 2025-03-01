<?php

namespace App\Livewire;

use App\Models\config\HeaderToggleParams;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ScreenRenderer extends Component
{
    public $params = array(
        "_local" => "dashboard",
        "_mode" => self::MODE_LIST,
    );

    public const MODE_LIST = "list";
    public const MODE_FORM = "form";

    #[On('changeScreen')]
    public function updateView($mode, $data) {      
        switch ($mode) {
            case $this::MODE_LIST:
                $this->params = array(
                    "_local" => $data['local'],
                    "_icon" => $data['icon'],
                    "_mode" => $this::MODE_LIST,
                );
                break;
        }

        session()->put('params', $this->params);
        $this->js("window.location.reload()");
    }

    public function mount() {
        $this->params = session('params', $this->params);
    }

    public function render()
    {
        return view("livewire.screen-renderer", $this->params);
    }
}
