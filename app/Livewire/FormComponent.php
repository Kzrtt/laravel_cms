<?php

namespace App\Livewire;

use App\Controllers\GenericCtrl;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Traits\DynamicFormTrait;
use TallStackUi\Traits\Interactions; 

/**
 * Classe para tratamento da rendereização dos formulários de maneira dinâmica
 * usando um arquivo .yaml previamente estruturados
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
#[Layout('components.layouts.app')]
class FormComponent extends Component
{
    use DynamicFormTrait;
    use Interactions;

    public $isEdit = false;

    //? Parametros vindo do screen-renderer através do click do botão de add [YAML]
    public $params = array();

    //* Função que carrega os dados na tela
    public function mount($local, $id = null)
    {
        $this->params = session('params');
        $this->params['_local'] = $local;
        $this->params['_id'] = $id;

        // Inicializa as variáveis antes de carregar o YAML
        $this->rules = [];
        $this->validationAttributes = [];
        $this->messages = [];
        $this->formConfig = [];
        $this->formData = [];
        $this->identifierToField = [];

        $this->renderUIViaYaml();

        if (!is_null($id)) {
            $this->isEdit = true;
            $genericCtrl = new GenericCtrl($local);
            $className = "App\\Models\\" . $local;
            $object = $genericCtrl->getObject($id);

            if ($object instanceof $className) {
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

    public function submitForm()
    {
        try {
            $this->validate();

            $formData = [];
            $genericCtrl = new GenericCtrl($this->params['_local']);

            // Aplica as funções de salvamento aos dados do formulário
            $this->applySaveFunctions($formData);

            if (!is_null($this->params['_id'])) {
                $genericCtrl->update($this->params['_id'], $formData);
                $this->dialog()
                ->success("Registro Alterado!", "Registro #".$this->params['_id']."  de ".$this->params['_title']." foi alterado com sucesso!")
                ->flash()
                ->send();
            } else {
                $genericCtrl->save($formData);
                $this->reset('formData');
                $this->dialog()
                ->success("Registro Criado!", "Registro de ".$this->params['_title']." foi criado com sucesso!")
                ->flash()
                ->send();
            }
            
            $this->js("window.history.back()");
        } catch (\Illuminate\Validation\ValidationException $ex) {
            $this->dialog()
            ->error("Erro no Formulário", $ex->validator->errors()->first())
            ->send();
        } catch (\Exception $ex) {
            $this->dialog()
            ->error("Erro Inesperado", $ex->getMessage())
            ->send();
        } 
    }

    public function render()
    {
        return view('livewire.form-component');
    }
}