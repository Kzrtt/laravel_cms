<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Controllers\YamlInterpreter;
use App\Controllers\GenericCtrl;
use Illuminate\Validation\ValidationException;
use TallStackUi\Traits\Interactions; 

/**
 * Classe para atribuição e remoção das permissões de um usuário
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */
#[Layout('components.layouts.app')]
class UserPermissionAssignScreen extends Component
{
    use Interactions;

    public $permissionsConfig = array();
    public $permissionData = array();
    public $databasePermissions = array();

    public $userName = "";
    public $usrId = "";
    public $prfId = "";

    public $totalAreas = 0;
    public $totalSubAreas = 0;
    public $permissionsAssigned = 0;

    public function mount($id) {
        $profileCtrl = new GenericCtrl("Profile");
        $userPermissionCtrl = new GenericCtrl("UserPermission");
        $userCtrl = new GenericCtrl("User");

        $user = $userCtrl->getObject($id);
        $userPermissions = $userPermissionCtrl->getObjectByField("users_usr_id", $id, false);
        $profile = $profileCtrl->getObjectByField("prf_entity", $user->usr_level);

        $this->prfId = $profile->prf_id;
        $this->usrId = $id;
        $this->generateUIViaYaml();
        
        $this->userName = $user->getPerson->pes_name;

        foreach ($userPermissions as $key => $permission) {
            $this->permissionsAssigned += 1;

            $this->permissionData[$permission->usp_area][$permission->usp_action] = true;
            $this->databasePermissions[$permission->usp_area][$permission->usp_action] = $permission->usp_id;
        }
    }

    public function generateUIViaYaml() {
        // Inicializa o controlador para 'ProfilePermission' e obtém as permissões do perfil
        $profilePermissionCtrl = new GenericCtrl("ProfilePermission");
        $prfPermissions = $profilePermissionCtrl->getObjectByField("profiles_prf_id", $this->prfId, false);

        // Interpreta o arquivo YAML e obtém a configuração de permissões
        $yamlPermissions = new YamlInterpreter('configMenu');
        $this->permissionsConfig = $yamlPermissions->getPermissionsFromConfig();

        // Cria um array associativo das permissões do perfil
        $profilePermissionArr = [];
        foreach ($prfPermissions as $permission) {
            $profilePermissionArr[$permission->prp_area][$permission->prp_action] = true;
        }

        // Filtra as permissões no permissionsConfig com base nas permissões do perfil
        foreach ($this->permissionsConfig as $groupKey => &$group) {
            foreach ($group['subItens'] as $subItemKey => &$subItem) {
                $area = $subItem['area'];
                // Verifica se a área está permitida
                if (!isset($profilePermissionArr[$area])) {
                    unset($group['subItens'][$subItemKey]);
                    continue;
                }
                // Filtra as permissões dentro da subárea
                if (isset($subItem['permissions']) && is_array($subItem['permissions'])) {
                    $subItem['permissions'] = array_filter($subItem['permissions'], function ($action) use ($profilePermissionArr, $area) {
                        return isset($profilePermissionArr[$area][$action]);
                    });
                }
                // Remove a subárea se não houver permissões restantes
                if (empty($subItem['permissions'])) {
                    unset($group['subItens'][$subItemKey]);
                } else {
                    foreach ($subItem['permissions'] as $action) {
                        $this->permissionData[$area][$action] = false;
                    }
                }
            }

            // Remove o grupo se não houver subáreas restantes
            if (empty($group['subItens'])) {
                unset($this->permissionsConfig[$groupKey]);
            }
        }

        unset($group, $subItem); // Remove referências para evitar efeitos colaterais

        // Atualiza o total de subáreas após a filtragem
        $this->totalSubAreas = array_reduce($this->permissionsConfig, function ($carry, $group) {
            return $carry + count($group['subItens']);
        }, 0);
    }

    public function submitForm() {
        try {
            $permissionCtrl = new GenericCtrl("UserPermission");

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
                            'usp_area' => $area,
                            'usp_action' => $action,
                            'users_usr_id' => $this->usrId,
                        ]);

                        $this->databasePermissions[$area][$action] = $nPermission->usp_id;
                        $this->permissionsAssigned += 1;
                    }
                }
            }

            $this->dialog()
            ->success("Sucesso!", "Permissões de '".$this->userName."' Alteradas com Sucesso")
            ->send();
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
        return view('livewire.user-permission-assign-screen');
    }
}
