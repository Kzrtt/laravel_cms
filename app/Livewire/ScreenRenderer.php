<?php

namespace App\Livewire;

use App\Models\config\HeaderToggleParams;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Classe responsável por lidar com a lógica de troca telas passando os parametros
 * para a UI poder lidar com qual view renderizar e passar os parametros necessários
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
#[Layout('components.layouts.app')]
class ScreenRenderer extends Component
{
    //? Parametros vindos do click do menu
    public $params = array(
        "_local" => "dashboard",
        "_mode" => self::MODE_LIST,
    );

    public const MODE_LIST = "list";
    public const MODE_FORM = "form";

    //* Função responsável por receber o evento de troca de tela
    #[On('changeScreen')]
    public function updateView($mode, $data) {      
        switch ($mode) {
            //? Tela de Listagem
            case $this::MODE_LIST:
                //? Resgatando arquivo para verificar se vai ser um list-default
                $filePath = base_path('core/'.$data['local'].'.yaml');

                //? Organizando valores para passar para a UI
                $this->params = array(
                    "_local" => file_exists($filePath) 
                        ? $data['local'] 
                        : (@$data['customView'] 
                            ? $data['customView'] 
                            : "dashboard"),
                    "_icon" => $data['icon'],
                    "_mode" => $this::MODE_LIST,
                    "_customView" => $data['customView'],
                );

                break;
        }

        //? Armazenando na sessão qual a tela atual 
        session()->put('params', $this->params);
        $this->js("window.location.reload()");
    }

    //* Função que recebe qual a tela atual se houver alguma
    public function mount() {
        $this->params = session('params', $this->params);
    }

    //* Carregando a View
    public function render()
    {
        return view("livewire.screen-renderer", $this->params);
    }
}
