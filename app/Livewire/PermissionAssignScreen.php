<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;
use App\Controllers\GenericCtrl;
use App\Models\UserPermission;
use Illuminate\Validation\ValidationException;
use TallStackUi\Traits\Interactions; 


/**
 * Classe para atribuição e remoção das permissões de um usuário
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class PermissionAssignScreen extends Component
{
    use Interactions;

    public $permissionsConfig = array();
    public $permissionData = array();
    public $databasePermissions = array();
    public $massPermissionData = array(
        'subarea' => '',
        'permission' => [],
    );

    public $profileName = "";
    public $prfId = "";

    public $totalAreas = 0;
    public $totalSubAreas = 0;
    public $permissionsAssigned = 0;
    public $totalUsers = 0;

    public $permissionModal = false;
    public $selectedSubarea = "";

    public function mount($id) {
        $profileCtrl = new GenericCtrl("Profile");
        $profilePermissionCtrl = new GenericCtrl("ProfilePermission");
        $userCtrl = new GenericCtrl("User");

        $profile = $profileCtrl->getObject($id);
        $profilePermissions = $profilePermissionCtrl->getObjectByField("profiles_prf_id", $id, false);
        $users = $userCtrl->getObjectByField("usr_level", $profile->prf_entity, false);

        $this->totalUsers = $users->count();

        $this->prfId = $id;
        
        $this->generateUIViaYaml();
        
        $this->profileName = $profile->prf_name;

        foreach ($profilePermissions as $key => $permission) {
            $this->permissionsAssigned += 1;

            $this->permissionData[$permission->prp_area][$permission->prp_action] = true;
            $this->databasePermissions[$permission->prp_area][$permission->prp_action] = $permission->prp_id;
        }
    }

    public function generateUIViaYaml() {
        $yamlPermissions = new YamlInterpreter('configMenu');
        $this->permissionsConfig = $yamlPermissions->getPermissionsFromConfig();

        foreach ($this->permissionsConfig as $key => $value) {
            $this->totalAreas += 1;
            foreach ($value['subItens'] as $key => $subItemValue) {
                $this->totalSubAreas += 1;
                foreach ($subItemValue['permissions'] as $key => $action) {
                    $this->permissionData[$subItemValue['area']][$action] = false;
                }
            }
        }
    }

    public function openModal() { 
        $this->permissionModal = true;
        $this->massPermissionData['permission'] = []; 
    }

    public function massRemovePermissions() {
        try {
            $userCtrl = new GenericCtrl("User");
            $profileCtrl = new GenericCtrl("Profile");
            $userPermissionCtrl = new GenericCtrl("UserPermission");

            $profile = $profileCtrl->getObject($this->prfId);

            $users = $userCtrl->getObjectByField(
                "usr_level", 
                $profile->prf_entity, 
                false
            );

            $count = 0;
            $countPermissions = 0;
            foreach ($users as $usr) {
                foreach ($this->massPermissionData['permission'] as $key => $permission) {
                    $usrPermission = $userPermissionCtrl->getObjectByFields(
                        array("usp_area", "usp_action", "users_usr_id"),
                        array($this->massPermissionData['subarea'], $permission, $usr->usr_id),
                    );

                    if($usrPermission instanceof UserPermission) {
                        $userPermissionCtrl->delete($usrPermission->usp_id);
                        $countPermissions += 1;
                    }
                }

                $count += 1;
            }

            $this->permissionModal = false;
            $this->toast()->success('Sucesso!', $countPermissions.' Permissões Removidas entre '.$count.' Usuários')->send();
        } catch (\Throwable $th) {
            $this->permissionModal = false;
            $this->toast()->error('Erro!', 'Ocorreu um erro ao conceder as permissões')->send();
        }
    }

    public function massAssignPermissions() {
        try {
            $userCtrl = new GenericCtrl("User");
            $profileCtrl = new GenericCtrl("Profile");
            $userPermissionCtrl = new GenericCtrl("UserPermission");

            $profile = $profileCtrl->getObject($this->prfId);

            $users = $userCtrl->getObjectByField(
                "usr_level", 
                $profile->prf_entity, 
                false
            );

            $count = 0;
            $countPermissions = 0;
            foreach ($users as $usr) {
                foreach ($this->massPermissionData['permission'] as $key => $permission) {
                    $usrPermission = $userPermissionCtrl->getObjectByFields(
                        array("usp_area", "usp_action", "users_usr_id"),
                        array($this->massPermissionData['subarea'], $permission, $usr->usr_id),
                    );

                    if(!$usrPermission instanceof UserPermission) {
                        $userPermissionCtrl->save([
                            'usp_area' => $this->massPermissionData['subarea'],
                            'usp_action' => $permission,
                            'users_usr_id' => $usr->usr_id,
                        ]);

                        $countPermissions += 1;
                    }
                }

                $count += 1;
            }

            $this->permissionModal = false;
            $this->toast()->success('Sucesso!', $countPermissions.' Permissões Concedidas entre '.$count.' Usuários')->send();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->permissionModal = false;
            $this->toast()->error('Erro!', 'Ocorreu um erro ao conceder as permissões')->send();
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
                        $this->permissionsAssigned -= 1;

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
                        $this->permissionsAssigned += 1;
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
