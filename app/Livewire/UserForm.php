<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\ValidationException;
use App\Controllers\GenericCtrl;
use App\Controllers\Utils\SaveFunctions;
use App\Traits\DynamicFormTrait;


#[Layout('components.layouts.app')]
class UserForm extends Component
{
    use DynamicFormTrait;

    public $isEdit = false;
    public $params = array();

    public function mount($local, $id = null) {
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

        $this->selectsPopulate['representedAgent'] = array();
        $this->formData['representedAgent'] = "";

        if(!is_null($id)) {
            $this->isEdit = true;

            $genericCtrl = new GenericCtrl($local);
            $userRepresentedAgentCtrl = new GenericCtrl("UserRepresentedAgent");

            $className = "App\\Models\\".$local;
            $object = $genericCtrl->getObject($id);
            $type = "App\\Models\\".$object->usr_level;
            $representedAgent = $userRepresentedAgentCtrl->getObjectByFields(
                ["ura_type", "users_usr_id"],
                [$type, $object->usr_id]
            );
            
            if($object instanceof $className) {
                $converted = [];
                $objectArray = $object->toArray();

                foreach ($this->identifierToField as $friendlyKey => $dbKey) {
                    $converted[$friendlyKey] = array_key_exists($dbKey, $objectArray) ? $objectArray[$dbKey] : null;
                }

                $this->formData = array_merge($this->formData, $converted);
                $this->formData['representedAgent'] = $representedAgent->represented_agent_id;
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
                
                if(array_key_exists($identifier, $this->saveFunctions)) {
                    $saveFunction = $this->saveFunctions[$identifier];
                    $formData[$this->identifierToField[$identifier]] = SaveFunctions::$saveFunction($value);
                } else {
                    $formData[$this->identifierToField[$identifier]] = $value;
                }
                
            }

            $formData['usr_level'] = $profile->prf_entity;

            if(!is_null($this->params['_id'])) {
                $user = $genericCtrl->update($this->params['_id'], $formData);
                $uraClass = "App\\Models\\UserRepresentedAgent";
                $representedAgent = $userRepresentedAgentCtrl->getObjectByFields(
                    ["ura_type", "users_usr_id"],
                    [$user->usr_level, $user->usr_id],
                );

                if($representedAgent instanceof $uraClass) {
                    if($representedAgent->represented_agent_id != $this->formData['representedAgent']) {
                        $userRepresentedAgentCtrl->save(
                            array(
                                'ura_type' => $profile->prf_entity,
                                'represented_agent_id' => $this->formData['representedAgent'],
                                'users_usr_id' => $user->usr_id,
                            )
                        );

                        $userRepresentedAgentCtrl->delete($representedAgent->ura_id);
                    }
                }
            } else {
                $user = $genericCtrl->save($formData);
                $userRepresentedAgentCtrl->save(
                    array(
                        'ura_type' => $profile->prf_entity,
                        'represented_agent_id' => $this->formData['representedAgent'],
                        'users_usr_id' => $user->usr_id,
                    )
                );

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
                text: $ex->getMessage() . " | " . $ex->getFile() . " | " . $ex->getLine() ,
                position: "center"
            );
        }   
    }
    
    public function render()
    {
        return view('livewire.user-form');
    }
}
