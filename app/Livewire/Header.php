<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class Header extends Component
{
    public $menuTabs = array();
    public $initialTab = "";
    public $teste = "teste";

    public function changeScreen($local)
    {
        dd($local);
        //$this->dispatch('changeScreen', local: $local);
    }

    public function mount() {
        $filePath = base_path('core/configMenu.yaml');
        $menuConfig = Yaml::parseFile($filePath);

        $tabId = 1;
        $subTabId = 1;
        foreach ($menuConfig['Areas'] as $area => $dataArea) {
            if(!isset($menuTabs[$area])) {
                if($tabId == 1)
                    $this->initialTab = $area;

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
