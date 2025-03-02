<?php

namespace App\Livewire;

use App\Models\config\HeaderToggleParams;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

/**
 * Classe para criação do menu de maneira dinâmica através do arquivo
 * configMenu.yaml onde tem uma estrutura personalizada para criação de tabs e subTabs
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
class Header extends Component
{
    //? Configurações para o menu
    public $menuTabs = array();
    public $configTabs = array();
    public $initialTab = "";
    public $initialSubTab = "";
    public $showNotification = true;
    public $showConfig = true;

    //* Método que dispara evento ao ScreenRenderer para troca da tela a ser apresentada
    public function changeScreen($data)
    {
        //? Envia o mode para o ScreenRenderer e um data contendo(local, icon, customView[NULLABLE]])
        $this->dispatch('changeScreen', mode: ScreenRenderer::MODE_LIST, data: $data);
    }

    //* Função que carrega os parâmetros para a UI para renderização do menu
    public function mount() {
        //? Carregando arquivo
        $filePath = base_path('core/configMenu.yaml');
        $menuConfig = Yaml::parseFile($filePath);

        //? Criando ids para manipulação dos tabs e subTabs
        $tabId = 1;
        $subTabId = 1;
        $configTabId = 1;
        foreach ($menuConfig['Areas'] as $area => $dataArea) {
            //? Gestão de Notificações
            if($area == "Notifications") {
                continue;
            }
            
            //? Telas que vão aparecer no menu da engrenagem
            if($area == "Sistema") {
                foreach($dataArea['subItens'] as $subItem => $value) {
                    $this->configTabs[] = array(
                        "id" => $configTabId,
                        "name" => $value['name'],
                        "icon" => $value['icon'],
                        "area" => $subItem,
                        "customView" => $value['customView'] ?? null
                    );

                    $configTabId++;
                }

                continue;
            }

            //? Armazenamento das tabs principais
            if(!isset($menuTabs[$area])) {
                if($tabId == 1) {
                    $this->initialTab = $area;
                }

                $this->menuTabs[$area] = array(
                    "name" => $dataArea['name'], 
                    "subTabs" => array(),
                );

                $tabId++;
            }

            //? Armazenamento das subTabs
            foreach ($dataArea['subItens'] as $subItem => $value) {
                $this->menuTabs[$area]['subTabs'][] = array(
                    "id" => $subTabId,
                    "name" => $value['name'],
                    "icon" => $value['icon'],
                    "area" => $subItem,
                    "customView" => $value['customView'] ?? null,
                );

                $subTabId++;
            }
        }

        //? Pegando os parametros da sessão para saber qual foi a tela clicada
        $params = null;
        $params = session('params', $params);

        $this->initialSubTab = $params != null ? ucfirst($params['_local']) : "";
    }   

    //* Carregando a view
    public function render()
    {
        return view('livewire.header');
    }
}
