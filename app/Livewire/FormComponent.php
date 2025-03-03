<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormComponent extends Component
{
    //? Parametros vindo do screen-renderer através do click do botão de add
    public $params = array();

    public $formConfig = array();

    public function mount($local, $icon) {
        //? Recebendo parametros
        $this->params = array(
            "_local" => $local,
            "_icon" => $icon,
        );

        //? Carregando arquivo
        $filePath = base_path('core/'.$local.'.yaml');
        $formConfig = array();

        if(file_exists($filePath)) {
            $formConfig = Yaml::parseFile($filePath)[$local];
        }

        foreach ($formConfig['formConfig'] as $field => $data) {
            if(!isset($this->formConfig[$data['groupIn']])) {
                $this->formConfig[$data['groupIn']] = array();
            }

            if(!isset($this->formConfig[$data['groupIn']][$data['line']])) {
                $this->formConfig[$data['groupIn']][$data['line']] = array();
            }

            $this->formConfig[$data['groupIn']][$data['line']][] = $data;
        }
    }

    public function render()
    {
        return view('livewire.form-component');
    }
}
