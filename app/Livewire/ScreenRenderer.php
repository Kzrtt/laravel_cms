<?php

namespace App\Livewire;

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
    protected $listeners = ["changeScreen" => '$refresh', "back" => '$refresh'];

    //? Parametros vindos do click do menu
    public $params = array(
        "_local" => "",
        "_mode" => self::MODE_LIST,
        "_view" => "dashboard"
    );

    //? Parametros da tela anterior
    public $lastView = array();

    public const MODE_LIST = "list";
    public const MODE_FORM = "form";

    //* Função responsável por redirecionar o usuário para a ultima tela
    #[On('back')]
    public function back() {
        $temp = $this->params;
        $this->params = session("lastViewParams", $this->params);
        $this->lastView = $temp;

        session()->put('params', $this->params);
        $this->dispatchUpdateToChild();
    }

    //* Função responsável por receber o evento de troca de tela
    #[On('changeScreen')]
    public function updateView($mode, $data) {   
        //? Armazenando ultima tela
        session()->put('lastViewParams', $this->params);

        switch ($mode) {
            //? Tela de Listagem
            case $this::MODE_LIST:
                //? Organizando valores para passar para a UI
                $this->params = array(
                    "_title" => $data['title'],
                    "_local" => $data['local'],
                    "_icon" => $data['icon'],
                    "_mode" => $this::MODE_LIST,
                    "_view" => @$data['customView'] ? $data['customView'] : 'list-component',
                );

                break;
            case $this::MODE_FORM:
                //? Organizando valores para passar para a UI
                $this->params = array(
                    "_local" => $data['_local'],
                    "_icon" => $data['_icon'],
                    "_title" => $data['_title'],
                    "_mode" => $this::MODE_FORM,
                    "_view" => @$data['_customView'] ? $data['_customView'] : 'form-component',
                );
        }

        //? Armazenando na sessão qual a tela atual 
        session()->put('params', $this->params);
        $this->dispatchUpdateToChild();

        return redirect()->route('list.component', ["local" => $this->params['_local']]);
    }

    public function dispatchUpdateToChild() {
        $controller = "App\\Livewire\\";
        switch ($this->params['_mode']) {
            case $this::MODE_LIST:
                $controller.= "ListComponent";
                break;
            case $this::MODE_FORM:
                $controller.= "FormComponent";
                break;
        }

        $this->dispatch("updateParams", $this->params)->to(app($controller)::class);    
    }

    //* Função que recebe qual a tela atual se houver alguma
    public function mount() {
        $this->params = session('params', $this->params);
    }

    //* Carregando a View
    public function render()
    {
        return view("livewire.screen-renderer");
    }
}
