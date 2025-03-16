<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;
use App\Controllers\GenericCtrl;
use Illuminate\Validation\ValidationException;

/**
 * Classe para atribuição e remoção das permissões de um usuário
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class PermissionAssignScreen extends Component
{
    public $permissionsConfig = array();
    public $permissionData = array();

    public $profileName = "";

    public function mount($id) {
        $profileCtrl = new GenericCtrl("Profile");
        $profile = $profileCtrl->getObject($id);
        
        $this->generateUIViaYaml();
        
        $this->profileName = $profile->prf_name;
    }

    public function generateUIViaYaml() {
        $yamlPermissions = new YamlInterpreter('configMenu');
        $this->permissionsConfig = $yamlPermissions->getPermissionsFromConfig();

        foreach ($this->permissionsConfig as $key => $value) {
            foreach ($value['subItens'] as $key => $subItemValue) {
                foreach ($subItemValue['permissions'] as $key => $action) {
                    $this->permissionData[$subItemValue['area']][$action] = false;
                }
            }
        }
    }

    public function submitForm() {
        try {
            
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
        return view('livewire.permission-assign-screen');
    }
}
