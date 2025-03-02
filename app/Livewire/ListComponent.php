<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Jantinnerezo\LivewireAlert\LivewireAlert;

/**
 * Classe para tratamento da visualização dinâmica dos registros
 * vindos do banco de dados usando um arquivo .yaml previamente estruturado
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
class ListComponent extends Component
{
    use LivewireAlert;

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

    //* Função que carrega as configs para poder montar os params para a UI
    public function mount($local, $icon) {
        //? Recebendo parametros do click
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );

        //? Carregando arquivo
        $filePath = base_path('core/'.$local.'.yaml');
        $listingConfig = array();
        
        if(file_exists($filePath)) {
            $listingConfig = Yaml::parseFile($filePath)[$local];
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
                $this->buttonsConfig[$button] = $data['value'];
            }
        }

        //? Carregando o controlador dinâmicamente
        $dao = $listingConfig['getConfig']['controller'];
        $getMethod = $listingConfig['getConfig']['method'];
        $daoCtrl = app("App\\Controllers\\".$dao);

        //? Marcando campo do id
        $this->identifier = $listingConfig['identifier'];

        $this->listingData = $daoCtrl->$getMethod($local);
    }

    //* Função que remove um registro
    public function delete($id) {
        //TODO::Implementar validação de permissão para o delete com o Auth
        try {
            $genericCtrl = new GenericCtrl($this->params['_local']);
            $genericCtrl->delete($id);

            $this->alert(
                "success", 
                "Registro removido!",
                array(
                    "position" => "center"
                )
            );

            $this->js("window.location.reload()");
        } catch (QueryException $ex) {
            if ($ex->getCode() == '23000') {
                // Aqui você pode lançar um erro customizado ou retornar uma mensagem de erro
                $this->alert(
                    "warning", 
                    "Não é possível apagar este '".$this->params['_local']."', pois há registros vinculados a ele.",
                    array(
                        "position" => "center"
                    )
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
