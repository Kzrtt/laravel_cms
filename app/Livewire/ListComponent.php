<?php

namespace App\Livewire;

use App\Controllers\ActionLogCtrl;
use App\Controllers\GenericCtrl;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;
use TallStackUi\Traits\Interactions; 

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
    use Interactions;

    protected $listeners = array("refresh" => '$refresh');

    //? Parametros vindo do screen-renderer através do click no menu
    public $params = array(
        "_icon" => "fad fa-yin-yang",
        "_title" => "Desconhecido",
    );
    
    //? Configurações da tabela, grid e botões da tela
    public $tableConfig = array();
    public $gridConfig = array();
    public $additionalSingleData = array();
    public $buttonsConfig = array(
        "showSearchButton" => true,
        "showInsertButton" => true,
        "showEditButton" => false,
        "showDetailsButton" => false,
        "showDeleteButton" => false
    );
    public $startsOn = "list";

    public $totalRegistries = 0;

    public $viewForm = "form.component";
    
    //? Registros para a listagem na página
    public $listingData = array();
    public $identifier = "";

    //? Variaveis pra controle dos registros
    public $getterMethod = "";
    public $controllerClass = "";
    public $controllerParams = [];

    public function renderUIViaYaml() {
        $yamlInterpreter = new YamlInterpreter($this->params['_local']);
        $listOutput = $yamlInterpreter->renderListUIData();

        $this->startsOn = $listOutput['startsOn'];
        $this->gridConfig = $listOutput['gridConfig'];
        $this->tableConfig = $listOutput['tableConfig'];
        $this->buttonsConfig = $listOutput['buttonsConfig'];
        $this->viewForm = $listOutput['viewForm'];
        $this->identifier = $listOutput['identifier'];
        $this->additionalSingleData = $listOutput['additionalSingleActions'];

        //? Carregando o controlador dinâmicamente
        $getConfig = $listOutput['getConfig'];

        //? Guarda apenas os dados simples (serializáveis)
        $this->getterMethod = $getConfig['method'];
        $this->controllerClass = "App\\Controllers\\" . $getConfig['controller'];
        $this->controllerParams = $getConfig['params'];

        // Faz a primeira carga dos dados
        $this->getData();
    }

    public function getData() {
        if ($this->controllerClass && $this->getterMethod) {
            $controller = app()->makeWith($this->controllerClass, $this->controllerParams);
            $this->listingData = $controller->{$this->getterMethod}($this->params['_local']);
            $this->totalRegistries = count($this->listingData);
        }
    }
    

    //* Função que carrega as configs para poder montar os params para a UI
    public function mount($local) {
        if(@session('usr_permissions')[$local]['Consult']) {
            //? Recebendo parametros do click
            $this->params = session('params');
            $this->params['_local'] = $local;
            $this->renderUIViaYaml();
        } else {
            $this->dialog()
            ->error("Atenção!", "Você não possui permissão para consultar esses registros ({$local})")
            ->flash()
            ->send();
            
            return redirect()->route('dashboard');
        }
    }

    //* Função que troca de tela para o form
    public function addNew() {
        if(@session('usr_permissions')[$this->params['_local']]['Insert']) {
            $route = $this->viewForm;
            return redirect()->route($route, ["local" => $this->params['_local']]);
        } else {
            $this->dialog()
            ->error('Atenção!', "Você não possui permissão para criarn novos registros desse tipo")
            ->send();
        }
    }

    public function editRegistry($id) {
        if(@session('usr_permissions')[$this->params['_local']]['Edit']) {
            $route = $this->viewForm;
            return redirect()->route($route, ["local" => $this->params['_local'], "id" => $id]);
        } else {
            $this->dialog()
            ->error('Atenção!', "Você não possui permissão para editar esse tipo de registro")
            ->send();
        }
    }

    public function redirectTo($route, $id) {
        return redirect()->route($route, ["id" => $id]);
    }

    public function openModal($modal, $id) {
        $this->dispatch('openModal', array('id' => $id, 'modal' => $modal))->to(ModalManager::class);
    }

    //* Função que remove um registro
    public function delete($id) {
        if(@session('usr_permissions')[$this->params['_local']]['Delete']) {
            $this->dialog()
            ->question('Atenção!', 'Tem certeza que deseja remover esse registro?')
            ->confirm(text: "Remover", method: 'commitDelete', params: $id)
            ->cancel("Cancelar", "cancelled", "Remoção Cancelada com Sucesso!")
            ->send();
        } else {
            $this->dialog()
            ->error('Atenção!', "Você não possui permissão para deletar esse tipo de registro")
            ->send();
        }
    }

    public function cancelled($message) {
        $this->toast()->error('Cancelado', $message)->send();
    }

    public function commitDelete($id) {
        //TODO::Implementar validação de permissão para o delete com o Auth
        try {
            $genericCtrl = new GenericCtrl($this->params['_local']);
            $object = $genericCtrl->getObject($id);
            $genericCtrl->delete($id);

            ActionLogCtrl::addLogInSystem(
                $this->params['_local'], 
                "Delete", 
                $object->toArray(), 
                $id
            );

            $this->toast()->success("Removido!", "Registro de ".$this->params['_title']." removido com sucesso!")->send();
            $this->getData();
        } catch (QueryException $ex) {
            if ($ex->getCode() == '23000') {
                // Aqui você pode lançar um erro customizado ou retornar uma mensagem de erro
                $this->dialog()
                ->error("Erro", "Não foi possivel apagar este registro de '".$this->params['_title']."', pois há registros vinculados a ele.")
                ->send();
            }
        } 
    }

    //* Carregando a view
    public function render()
    {
        return view('livewire.list-component');
    }
}
