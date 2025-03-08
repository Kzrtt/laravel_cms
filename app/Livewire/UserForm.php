<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;

#[Layout('components.layouts.app')]
class UserForm extends Component
{
    //? Parametros usados pelo próprio livewire através das funções protected [YAML]
    public $rules = array();
    public $validationAttributes = array();
    public $messages = array();
    
    //? Configurações para a UI do form [YAML]
    public $formConfig = array();

    //? Dados que vão ser carregados do form para o controller [YAML]
    public $formData = array();
    public $selectsPopulate = array();

    //? Map associativo para construir parametro do insert [YAML]
    public $identifierToField = array();

    public $permissionsConfig = array();

    public $params = array();

    protected function rules() {
        return $this->rules;
    }

    protected function messages() {
        return $this->messages;
    }

    public function mount($local) {
        $this->params = session('params');
        $this->params['_local'] = $local;

        $this->rules = array();
        $this->validationAttributes = array();
        $this->messages = array();
        $this->formConfig = array();
        $this->formData = array();
        $this->identifierToField = array();

        $this->renderUIViaYaml();

        $yamlPermissions = new YamlInterpreter('configMenu');
        $this->permissionsConfig = $yamlPermissions->getPermissionsFromConfig();
    }

    public function renderUIViaYaml() {
        //? Carregando arquivo
        $yamlInterpreter = new YamlInterpreter($this->params['_local']);
        $formOutput = $yamlInterpreter->renderFormUIData();

        $this->formConfig = $formOutput['formConfig'];
        $this->selectsPopulate = $formOutput['selectsPopulate'];
        $this->messages = $formOutput['messages'];
        $this->rules = $formOutput['rules'];
        $this->validationAttributes = $formOutput['validationAttributes'];
        $this->formData = $formOutput['formData'];
        $this->identifierToField = $formOutput['identifierToFied'];
    }
    
    public function render()
    {
        return view('livewire.user-form');
    }
}
