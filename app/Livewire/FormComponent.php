<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Livewire\Attributes\On;

/**
 * Classe para tratamento da rendereização dos formulários de maneira dinâmica
 * usando um arquivo .yaml previamente estruturados
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class FormComponent extends Component
{
    //? Parametros usados pelo próprio livewire através das funções protected
    public $rules = array();
    public $validationAttributes = array();
    public $messages = array();

    //? Parametros vindo do screen-renderer através do click do botão de add
    public $params = array();
    
    //? Configurações para a UI do form
    public $formConfig = array();

    //? Dados que vão ser carregados do form para o controller
    public $formData = array();
    public $selectsPopulate = array();

    //? Map associativo para construir parametro do insert
    public $identifierToField = array();

    //* Funções para o tratamento de erros e validações do formulário
    protected function rules() {
        return $this->rules;
    }

    protected function messages() {
        return $this->messages;
    }

    //* Função que carrega os dados na tela
    public function mount($local) {
        //? Recebendo parametros
        $this->params = session('params');
        $this->params['_local'] = $local;

        $this->rules = array();
        $this->validationAttributes = array();
        $this->messages = array();
        $this->formConfig = array();
        $this->formData = array();
        $this->identifierToField = array();

        $this->renderUIViaYaml();
    }

    public function renderUIViaYaml() {
        //? Carregando arquivo
        $filePath = base_path('core/'.$this->params['_local'].'.yaml');
        $formConfig = array();

        if(file_exists($filePath)) {
            $formConfig = Yaml::parseFile($filePath)[$this->params['_local']];
        }

        foreach ($formConfig['formConfig'] as $field => $data) {
            //? Carregando configurações da UI do formulário
            if(!isset($this->formConfig[$data['groupIn']])) {
                $this->formConfig[$data['groupIn']] = array();
            }

            if(!isset($this->formConfig[$data['groupIn']][$data['line']])) {
                $this->formConfig[$data['groupIn']][$data['line']] = array();
            }

            if($data['type'] == "select" || $data['type'] == "relation") {
                if(!isset($this->selectsPopulate[$data['identifier']])) {
                    $this->selectsPopulate[$data['identifier']] = array();
                }

                if(@$data['values']) {
                    $this->selectsPopulate[$data['identifier']] = $data['values'];
                }
            }

            //? Adicionando as validações nos campos
            if(isset($data['validationRules'])) {
                $validationString = "";
                foreach ($data['validationRules'] as $validation) {
                    if(strpos($validation, ":") !== false) {
                        $rule = explode(":", $validation)[0];
                    } else {
                        $rule = $validation;
                    }

                    if($rule == "required") {
                        $data['required'] = true;
                    }

                    $this->messages['formData.'.$data['identifier'].'.'.$rule] = getMessageForValidation($rule);
                    $validationString.= $validation . "|";
                }

                $this->rules['formData.'.$data['identifier']] = $validationString;
            }

            $this->formConfig[$data['groupIn']][$data['line']][] = $data;
            
            //? Passando aliases para os campos
            $this->validationAttributes['formData.'.$data['identifier']] = $data['label'];

            //? Criando mapeamento entre identifiers e nomes no banco
            $this->formData[$data['identifier']] = "";
            $this->identifierToField[$data['identifier']] = $field;
        }
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

            $genericCtrl->save($formData);

            $this->reset('formData');

            $this->dispatch('alert',
                icon: "success",
                title: "Sucesso!",
                position: "center"
            );

            $this->dispatch('back')->to(ScreenRenderer::class);
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