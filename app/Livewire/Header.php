<?php

namespace App\Livewire;

use App\Models\config\HeaderToggleParams;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions; 

/**
 * Classe para criação do menu de maneira dinâmica através do arquivo
 * configMenu.yaml onde tem uma estrutura personalizada para criação de tabs e subTabs
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
class Header extends Component
{
    use Interactions;

    //? Configurações para o menu
    public $menuTabs = array();
    public $configTabs = array();
    public $initialTab = "";
    public $initialSubTab = "";
    public $showNotification = true;
    public $showConfig = true;

    public function changeScreen($data)
    {
        session()->put('params', $data);

        $route = $data['_view'] ?? "list.component";

        return redirect()->route($route, ["local" => $data['_local']]);
    }

    public function confirmLoggout() {
        $this->dialog()
        ->question('Atenção!', 'Tem certeza Sair?')
        ->confirm(text: "Sair", method: 'loggout')
        ->cancel("Cancelar")
        ->send();
    }

    public function loggout() {
        Auth::logout();
        return redirect()->route('login');
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
