<?php 

namespace App\Traits;

use App\Controllers\YamlInterpreter;
use App\Controllers\GenericCtrl;
use App\Controllers\Utils\SaveFunctions;

trait DynamicFormTrait {
    //? Controle do formulário
    public $rules = [];
    public $validationAttributes = [];
    public $messages = [];
    public $formConfig = [];
    public $selectsPopulate = [];
    public $remoteUpdates = [];
    public $saveFunctions = [];

    //? Dados que vão ser enviados para o banco
    public $formData = [];
    public $identifierToField = [];

    public $saveConfig = [];

    //* Funções para o tratamento de erros e validações do formulário
    protected function rules() {
        return $this->rules;
    }

    protected function messages() {
        return $this->messages;
    }

    public function renderUIViaYaml()
    {
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
        $this->saveFunctions = $formOutput['saveFunctions'];
        $this->saveConfig = $formOutput['saveConfig'];
    }

    /**
     * Aplica as funções de salvamento definidas (como encriptação) aos dados.
     * Preenche o array $formData já mapeado com os dados processados.
     */
    protected function applySaveFunctions(array &$processedData)
    {
        foreach ($this->formData as $identifier => $value) {
            if (array_key_exists($identifier, $this->saveFunctions)) {
                $saveFunction = $this->saveFunctions[$identifier];
                if (method_exists(SaveFunctions::class, $saveFunction)) {
                    // Chama o método estático de forma dinâmica e atribui o resultado
                    $processedData[$this->identifierToField[$identifier]] = SaveFunctions::$saveFunction($value);
                } else {
                    throw new \Exception("Método estático '{$saveFunction}' não existe em SaveFunctions.");
                }
            } else {
                $processedData[$this->identifierToField[$identifier]] = $value;
            }
        }
    }

    public function updateRemoteField($parentIdentifier, $updateRemoteConfig)
    {
        $genericCtrl = new GenericCtrl($this->params['_local']);

        $remoteData = $genericCtrl->getRemoteData(
            $this->formData[$parentIdentifier],
            $updateRemoteConfig
        );

        $this->selectsPopulate[$updateRemoteConfig['remoteIdentifier']] = $remoteData;
    }
}