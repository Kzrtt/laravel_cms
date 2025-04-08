<?php

namespace App\Livewire;

use App\Traits\DynamicFormTrait;
use TallStackUi\Traits\Interactions; 
use App\Controllers\GenericCtrl;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use App\Controllers\Utils\SaveFunctions;
use App\Models\Recipe;

/**
 * Classe para tratamento da rendereização da tela de cadastro e edição de receitas.
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
class RecipeForm extends Component
{
    use DynamicFormTrait;
    use Interactions;

    public $isEdit = false;
    public $params = array();

    public $ingredients = array();
    public $measurementUnits = array();

    public $estId = "";
    public $establishmentName = "";

    public $formIngredients = array();

    public function addIngredient() {
        $this->formIngredients[] = array(
            "id" => "0",
            "ingredient" => "",
            "quantity" => "",
            "measurement_unit" => "" 
        );
    }

    public function removeIngredient($reiId, $key) {
        if($reiId == "0") {
            unset($this->formIngredients[$key]);

            $this->toast()
            ->success("Sucesso!", "Ingredientes Removido com Sucesso!")
            ->send();
        } else {
            $this->dialog()
            ->question('Atenção!', 'Quer mesmo remover esse Ingrediente?')
            ->confirm(text: "Sim, Remover", method: 'commitRemoveIngredient', params: ["id" => $reiId, "key" => $key])
            ->cancel("Cancelar")
            ->send();
        }
    }

    public function commitRemoveIngredient($params) {
        $recipeIngredientCtrl = new GenericCtrl("RecipeIngredient");
        $recipeIngredientCtrl->delete($params['id']);
        unset($this->formIngredients[$params['key']]);

        $this->toast()
        ->success("Sucesso!", "Ingredientes Removido com Sucesso!")
        ->send();
    }

    public function mount($local, $id = null) {
        $this->params = session('params');
        $this->params['_id'] = $id;
        $this->estId = session('est_id');

        $this->loadSelects();
        $this->renderUIViaYaml();

        if(!is_null($id)) {
            $this->isEdit = true;

            $genericCtrl = new GenericCtrl($local);
            $recipe = $genericCtrl->getObject($id);
            $this->estId = $recipe->establishment_est_id;
            
            if($recipe instanceof Recipe) {
                $converted = [];
                $objectArray = $recipe->toArray();

                foreach ($this->identifierToField as $friendlyKey => $dbKey) {
                    $converted[$friendlyKey] = array_key_exists($dbKey, $objectArray) ? $objectArray[$dbKey] : null;
                }

                $this->formData = array_merge($this->formData, $converted);

                foreach ($recipe->recipeIngredients as $key => $value) {
                    $this->formIngredients[] = array(
                        "id" => $value->rei_id,
                        "ingredient" => $value->ingredients_ing_id,
                        "quantity" => $value->rei_quantity,
                        "measurement_unit" => $value->measurement_unit_msu_id 
                    );
                }
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

        $establishmentCtrl = new GenericCtrl("Establishment");
        $establishment = $establishmentCtrl->getObject($this->estId);
        $this->establishmentName = $establishment->est_fantasy;
    }

    public function loadSelects() {
        $ingredientsCtrl = new GenericCtrl("Ingredient");
        $measurementUnitCtrl = new GenericCtrl("MeasurementUnit");

        $ingredients = $ingredientsCtrl->getAll();
        $measurementUnits = $measurementUnitCtrl->getAll();

        $ingArray = array();
        foreach ($ingredients as $value) {
            $ingArray[] = $value->toArray();
        }
        $this->ingredients = $ingArray;

        $msuArray = array();
        foreach ($measurementUnits as $value) {
            $msuArray[] = $value->toArray();
        }
        $this->measurementUnits = $msuArray;
    }

    public function submitFormIngredients() {
        try {
            $recipeIngredientCtrl = new GenericCtrl("RecipeIngredient");

            foreach ($this->formIngredients as $key => $value) {
                if($value['id'] == "0") {
                    $recipeIngredientCtrl->save(array(
                        'rei_quantity' => $value['quantity'],
                        'recipe_rec_id' => $this->params['_id'],
                        'ingredients_ing_id' => $value['ingredient'],
                        'measurement_unit_msu_id' => $value['measurement_unit']
                    ));
                } else {
                    $recipeIngredientCtrl->update($value['id'], array(
                        'rei_quantity' => $value['quantity'],
                        'measurement_unit_msu_id' => $value['measurement_unit']
                    ));
                }
            }

            $this->dialog()
            ->success("Sucesso!", "Ingredientes adicionados com sucesso!")
            ->flash()
            ->send();

            $this->js("window.location.reload()");
        } catch (\Exception $ex) {
            $this->dialog()
            ->error("Erro Inesperado", $ex->getMessage())
            ->send();
        }   
    }

    public function submitForm() {
        try {
            $this->validate();

            //? Criação do Usuário
            $formData = array();
            $genericCtrl = new GenericCtrl($this->params['_local']);

            foreach ($this->formData as $identifier => $value) {                
                if(array_key_exists($identifier, $this->saveFunctions)) {
                    $saveFunction = $this->saveFunctions[$identifier];
                    $formData[$this->identifierToField[$identifier]] = SaveFunctions::$saveFunction($value);
                } else {
                    $formData[$this->identifierToField[$identifier]] = $value;
                }
                
            }

            if(!is_null($this->params['_id'])) {
                $recipe = $genericCtrl->update($this->params['_id'], $formData);
            } else {
                $formData['establishment_est_id'] = $this->estId;
                $recipe = $genericCtrl->save($formData);
            }
            
            $this->dialog()
            ->success("Sucesso!", "Receita criado com sucesso!")
            ->flash()
            ->send();

            $this->js("window.location = '/admin/Recipe/RecipeForm/{$recipe->rec_id}';");
        } catch (ValidationException $ex) {
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
        return view('livewire.recipe-form');
    }
}
