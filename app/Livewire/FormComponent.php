<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Controllers\YamlInterpreter;

/**
 * Classe para tratamento da rendereização dos formulários de maneira dinâmica
 * usando um arquivo .yaml previamente estruturados
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class FormComponent extends Component
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
    public $remoteUpdates = array();

    //? Map associativo para construir parametro do insert [YAML]
    public $identifierToField = array();

    //? Parametros vindo do screen-renderer através do click do botão de add [YAML]
    public $params = array();

    //* Funções para o tratamento de erros e validações do formulário
    protected function rules() {
        return $this->rules;
    }

    protected function messages() {
        return $this->messages;
    }

    //* Função que carrega os dados na tela
    public function mount($local, $id = null) {
        //? Recebendo parametros
        $this->params = session('params');
        $this->params['_local'] = $local;
        $this->params['_id'] = $id;

        $this->rules = array();
        $this->validationAttributes = array();
        $this->messages = array();
        $this->formConfig = array();
        $this->formData = array();
        $this->identifierToField = array();

        $this->renderUIViaYaml();

        if(!is_null($id)) {
            $genericCtrl = new GenericCtrl($local);
            $className = "App\\Models\\".$local;
            $object = $genericCtrl->getObject($id);
            
            if($object instanceof $className) {
                $converted = [];
                $objectArray = $object->toArray();

                foreach ($this->identifierToField as $friendlyKey => $dbKey) {
                    $converted[$friendlyKey] = array_key_exists($dbKey, $objectArray) ? $objectArray[$dbKey] : null;
                }

                $this->formData = array_merge($this->formData, $converted);
            }

            foreach ($this->remoteUpdates as $identifier => $remoteConfig) {
                if (!empty($this->formData[$identifier])) {
                    if (!empty($remoteConfig['customRemote'])) {
                        $customMethod = $remoteConfig['customRemote'];
                        $this->{$customMethod}();
                    } else {
                        $this->updateRemoteField($identifier, $remoteConfig);
                    }
                }
            }
            
        }
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
        $this->remoteUpdates = $formOutput['remoteUpdates'];
    }

    public function updateRemoteField($parentIdentifier, $updateRemoteConfig) {
        $genericCtrl = new GenericCtrl($this->params['_local']);

        $remoteData = $genericCtrl->getRemoteData(
            $this->formData[$parentIdentifier], 
            $updateRemoteConfig
        );

        $this->selectsPopulate[$updateRemoteConfig['remoteIdentifier']] = $remoteData;
    }

    public function teste() {
        dd($this->formData);
    }

    //* Função que envia o formulário
    public function submitForm() {
        try {
            $this->validate();

            $formData = array();
            $genericCtrl = new GenericCtrl($this->params['_local']);

            foreach ($this->formData as $identifier => $value) {
                $formData[$this->identifierToField[$identifier]] = $value;
            }

            if(!is_null($this->params['_id'])) {
                $genericCtrl->update($this->params['_id'], $formData);
            } else {
                $genericCtrl->save($formData);
                $this->reset('formData');
            }

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

    //* Função que renderiza a view
    public function render()
    {
        return view('livewire.form-component');
    }
}