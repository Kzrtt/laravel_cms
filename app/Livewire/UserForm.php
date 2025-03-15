<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;
use Illuminate\Validation\ValidationException;
use App\Controllers\GenericCtrl;

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

        $this->selectsPopulate['representedAgent'] = array();
        $this->formData['representedAgent'] = "";

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
        $this->identifierToField = $formOutput['identifierToField'];
    }

    public function redirectToPermissions() {
        
    }

    public function getRepresentedAgents() {
        $profileCtrl = new GenericCtrl("Profile");
        
        $prfId = $this->formData['profile'];
        $profile = $profileCtrl->getObject($prfId);

        $fetchModel = "App\\Models\\".$profile->prf_entity;
        $this->selectsPopulate['representedAgent'] = $fetchModel::select()->get()->pluck("est_fantasy", "est_id")->toArray();
    }

    public function submitForm() {
        try {
            $this->validate();

            //? Criação do Usuário
            $formData = array();
            $genericCtrl = new GenericCtrl($this->params['_local']);
            $profileCtrl = new GenericCtrl("Profile");
            $userRepresentedAgentCtrl = new GenericCtrl("UserRepresentedAgent");

            $profile = $profileCtrl->getObject($this->formData['profile']);

            foreach ($this->formData as $identifier => $value) {
                if($identifier == "representedAgent") {
                    continue;
                }
                
                $formData[$this->identifierToField[$identifier]] = $value;
            }

            $formData['usr_level'] = $profile->prf_entity;

            $user = $genericCtrl->save($formData);

            $userRepresentedAgentCtrl->save(
                array(
                    'ura_type' => $profile->prf_entity,
                    'represented_agent_id' => $this->formData['representedAgent'],
                    'users_usr_id' => $user->usr_id,
                )
            );

            //? Atribuição das Permissões

            $this->reset('formData');

            $this->dispatch('alert',
                icon: "success",
                title: "Sucesso!",
                position: "center"
            );

            $this->js("window.history.back()");
        } catch (ValidationException $ex) {
            $this->dispatch('alert',
                icon: "error",
                title: "Erro no Formulário",
                text: $ex->validator->errors()->first(),
                position: "center"
            );
        } catch (\Exception $ex) {
            $this->dispatch('alert',
                icon: "error",
                title: "Erro Inesperado",
                text: $ex->getMessage(),
                position: "center"
            );
        }   
    }
    
    public function render()
    {
        return view('livewire.user-form');
    }
}
