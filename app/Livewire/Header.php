<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class Header extends Component
{
    public $menuTabs = array();
    public $configTabs = array();
    public $initialTab = "";
    public $showNotification = true;
    public $showConfig = true;

    public function changeScreen($local)
    {
        $this->dispatch('changeScreen', mode: ScreenRenderer::MODE_LIST, local: $local);
    }

    public function mount() {
        $filePath = base_path('core/configMenu.yaml');
        $menuConfig = Yaml::parseFile($filePath);

        $tabId = 1;
        $subTabId = 1;
        $configTabId = 1;
        foreach ($menuConfig['Areas'] as $area => $dataArea) {
            //? Menu Config
            if($area == "Notifications") {
                continue;
            }
            
            if($area == "Sistema") {
                foreach($dataArea['subItens'] as $subItem => $value) {
                    $this->configTabs[] = array(
                        "id" => $configTabId,
                        "name" => $value['name'],
                        "icon" => $value['icon'],
                        "area" => $subItem,
                    );

                    $configTabId++;
                }

                continue;
            }

            //? Menu
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

            foreach ($dataArea['subItens'] as $subItem => $value) {
                $this->menuTabs[$area]['subTabs'][] = array(
                    "id" => $subTabId,
                    "name" => $value['name'],
                    "icon" => $value['icon'],
                );

                $subTabId++;
            }
        }
    }

    public function render()
    {
        return view('livewire.header');
    }
}
