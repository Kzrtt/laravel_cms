<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;

/**
 * Classe para tratamento da visualização dinâmica dos registros
 * vindos do banco de dados usando um arquivo .yaml previamente estruturado
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class ListComponent extends Component
{
    use LivewireAlert;

    protected $listeners = array("refresh" => '$refresh');

    //? Parametros vindo do screen-renderer através do click no menu
    public $params = array(
        "_icon" => "fad fa-yin-yang",
        "_title" => "Desconhecido",
    );
    
    //? Configurações da tabela, grid e botões da tela
    public $tableConfig = array();
    public $gridConfig = array();
    public $buttonsConfig = array(
        "showSearchButton" => true,
        "showInsertButton" => true,
        "showEditButton" => false,
        "showDetailsButton" => false,
        "showDeleteButton" => false
    );
    public $startsOn = "list";

    public $viewForm = "form.component";
    
    //? Registros para a listagem na página
    public $listingData = array();
    public $identifier = "";
    
    public $daoCtrl = null;

    public function renderUIViaYaml() {
        $yamlInterpreter = new YamlInterpreter($this->params['_local']);
        $listOutput = $yamlInterpreter->renderListUIData();

        $this->startsOn = $listOutput['startsOn'];
        $this->gridConfig = $listOutput['gridConfig'];
        $this->tableConfig = $listOutput['tableConfig'];
        $this->buttonsConfig = $listOutput['buttonsConfig'];
        $this->viewForm = $listOutput['viewForm'];
        $this->identifier = $listOutput['identifier'];

        //? Carregando o controlador dinâmicamente
        $getConfig = $listOutput['getConfig'];
        $getMethod = $getConfig['method'];
        $daoCtrl = app()->makeWith("App\\Controllers\\".$getConfig['controller'], $getConfig['params']);

        $this->listingData = $daoCtrl->$getMethod($this->params['_local']);
    }

    //* Função que carrega as configs para poder montar os params para a UI
    public function mount($local) {
        //? Recebendo parametros do click
        $this->params = session('params');
        $this->params['_local'] = $local;
        $this->renderUIViaYaml();
    }

    //* Função que troca de tela para o form
    public function addNew() {
        $route = $this->viewForm;
    
        return redirect()->route($route, ["local" => $this->params['_local']]);
    }

    //* Função que remove um registro
    public function delete($id) {
        //TODO::Implementar validação de permissão para o delete com o Auth
        try {
            $genericCtrl = new GenericCtrl($this->params['_local']);
            $genericCtrl->delete($id);

            $this->dispatch('alert',
                icon: "success",
                title: "Registro Removido!",
                position: "center"
            );

            $this->js("window.location.reload()");
        } catch (QueryException $ex) {
            if ($ex->getCode() == '23000') {
                // Aqui você pode lançar um erro customizado ou retornar uma mensagem de erro
                $this->dispatch('alert',
                    icon: "warning",
                    title: "Cuidado!",
                    text: "Não é possível apagar este '".$this->params['_local']."', pois há registros vinculados a ele.",
                    position: "center"
                );
            }
        } 
    }

    //* Carregando a view
    public function render()
    {
        return view('livewire.list-component');
    }
}
