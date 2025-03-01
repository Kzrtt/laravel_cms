<?php

namespace App\Livewire;

use App\CMSFunctions;
use App\Models\Profile;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class ListComponent extends Component
{
    public $params = array();
    
    public $tableConfig = array();
    public $gridConfig = array();
    public $buttonsConfig = array(
        "showSearchButton" => true,
        "showInsertButton" => true,
        "showEditButton" => false,
        "showDetailsButton" => false,
        "showDeleteButton" => false
    );
    
    public $listingData = array();

    public function mount($local, $icon) {
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );

        $filePath = base_path('core/'.$local.'.yaml');
        $listingConfig = array();
        
        if(file_exists($filePath)) {
            $listingConfig = Yaml::parseFile($filePath)[$local];
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

        $this->listingData = Profile::all();
    }

    public function render()
    {
        return view('livewire.list-component');
    }
}
