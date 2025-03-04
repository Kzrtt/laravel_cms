<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

/**
 * Classe para tratamento da visualização dinâmica dos registros
 * vindos do banco de dados usando um arquivo .yaml previamente estruturado
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
class ListComponent extends Component
{
    use LivewireAlert;

    protected $listeners = array("refresh" => '$refresh');

    //? Parametros vindo do screen-renderer através do click no menu
    public $params = array();
    
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
    
    //? Registros para a listagem na página
    public $listingData = array();
    public $identifier = "";
    
    public $daoCtrl = null;

    #[On('updateParams')]
    public function updateParams($params) { $this->params = $params; $this->renderUIViaYaml(); }

    public function renderUIViaYaml() {
        $this->tableConfig = array();
        $this->gridConfig = array();
        $this->buttonsConfig = array(
            "showSearchButton" => true,
            "showInsertButton" => true,
            "showEditButton" => false,
            "showDetailsButton" => false,
            "showDeleteButton" => false
        );
        $this->startsOn = "list";

        //? Carregando arquivo
        $filePath = base_path('core/'.$this->params['_local'].'.yaml');
        $listingConfig = array();
        
        if(file_exists($filePath)) {
            $listingConfig = Yaml::parseFile($filePath)[$this->params['_local']];
        }

        //? Pegando configurações da tabela, grid e botões
        if(key_exists('startsOn', $listingConfig)) {
            $this->startsOn = $listingConfig['startsOn'];
        }

        if(key_exists('listingConfig', $listingConfig)) {
            foreach ($listingConfig['listingConfig'] as $type => $data) {
                foreach ($data as $field => $config) {
                    $typeConfig = $type."Config";
                    $this->$typeConfig[$field] = $config;
                }            
            }
        }

        if(key_exists('buttonsConfig', $listingConfig)) {
            foreach ($listingConfig['buttonsConfig'] as $button => $data) {
                $this->buttonsConfig[$button] = $data;
            }
        }

        //? Carregando o controlador dinâmicamente
        $dao = $listingConfig['getConfig']['controller'];
        $getMethod = $listingConfig['getConfig']['method'];
        $daoCtrl = app("App\\Controllers\\".$dao);

        //? Marcando campo do id
        $this->identifier = $listingConfig['identifier'];

        $this->listingData = $daoCtrl->$getMethod($this->params['_local']);
    }

    //* Função que carrega as configs para poder montar os params para a UI
    public function mount($local, $icon) {
        //? Recebendo parametros do click
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );

        $this->renderUIViaYaml();
    }

    //* Função que dispara evento para troca de tela para o form
    public function addNew() {
        //? Envia o mode para o ScreenRenderer e um data contendo(local, icon, customView[NULLABLE]])
        $this->dispatch('changeScreen', mode: ScreenRenderer::MODE_FORM, data: $this->params)->to(ScreenRenderer::class);
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
