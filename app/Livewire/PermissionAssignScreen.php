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
    public $databasePermissions = array();

    public $profileName = "";
    public $prfId = "";

    public function mount($id) {
        $profileCtrl = new GenericCtrl("Profile");
        $profilePermissionCtrl = new GenericCtrl("ProfilePermission");

        $profile = $profileCtrl->getObject($id);
        $profilePermissions = $profilePermissionCtrl->getObjectByField("profiles_prf_id", $id, false);

        $this->prfId = $id;
        
        $this->generateUIViaYaml();
        
        $this->profileName = $profile->prf_name;

        foreach ($profilePermissions as $key => $permission) {
            $this->permissionData[$permission->prp_area][$permission->prp_action] = true;
            $this->databasePermissions[$permission->prp_area][$permission->prp_action] = $permission->prp_id;
        }
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
            $permissionCtrl = new GenericCtrl("ProfilePermission");

            foreach ($this->permissionData as $area => $actionArr) {
                foreach ($actionArr as $action => $value) {
                    if(isset($this->databasePermissions[$area]) && array_key_exists($action, $this->databasePermissions[$area])) {
                        if($value) {
                            //? Caso a permissão já exista na database apenas passa para próxima
                            continue;
                        }

                        //? Caso a permissão exista na database mas o valor agora está falso ela é apagada
                        $permissionCtrl->delete($this->databasePermissions[$area][$action]);
                        unset($this->databasePermissions[$area][$action]);

                        continue;
                    } 
                    
                    if($value) {
                        //? Caso o valor não exista na base de dados e está com o valor true é criado
                        $nPermission = $permissionCtrl->save([
                            'prp_area' => $area,
                            'prp_action' => $action,
                            'profiles_prf_id' => $this->prfId,
                        ]);

                        $this->databasePermissions[$area][$action] = $nPermission->prp_id;
                    }
                }
            }

            $this->dispatch('alert',
                icon: "success",
                title: "Sucesso!",
                position: "center"
            );
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
