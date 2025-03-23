<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Traits\DynamicFormTrait;
use App\Controllers\UserCtrl;
use App\Controllers\GenericCtrl;

/**
 * Classe para tratamento da rendereização da tela de perfil de usuário
 * assim como a manipulação dos dados referentes a ele.
 * 
 * @author Felipe Kurt <fe.hatunaqueton@gmail.com>
 */

#[Layout('components.layouts.app')]
class ProfileScreen extends Component
{
    use DynamicFormTrait;

    public $isEdit = true;
    public $params = array();

    public $passwordForm = array(
        "current" => "",
        "new" => "",
        "confirm" => ""
    );

    public function mount() {
        $this->params['_local'] = "Person";
        $this->renderUIViaYaml();

        $genericCtrl = new GenericCtrl("Person");
        $className = "App\\Models\\Person";
        $object = $genericCtrl->getObject(auth()->user()->getPerson->pes_id);

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

    public function loggout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function submitFormPassword() {
        try {
            $userCtrl = new UserCtrl();
            $userId = auth()->user()->usr_id;
            
            if($this->passwordForm['new'] != $this->passwordForm['confirm']) {
                $this->dispatch(
                    'alert', 
                    icon: "error", 
                    title: "Erro no Formulário", 
                    text: "As senhas não conferem", 
                    position: "center"
                );
                return;
            }

            $response = $userCtrl->updateUserPassword(
                $userId, 
                $this->passwordForm['current'],
                $this->passwordForm['new'],
            );

            if(!$response['status']) {
                $this->dispatch(
                    'alert', 
                    icon: "error", 
                    title: "Erro...", 
                    text: $response['message'], 
                    position: "center"
                );
                return;
            }

            $this->dispatch('alert', icon: "success", title: "Sucesso!", position: "center");
            $this->reset('passwordForm');
            $this->js("window.refresh()");
        } catch (\Illuminate\Validation\ValidationException $ex) {
            $this->dispatch('alert', icon: "error", title: "Erro no Formulário", text: $ex->validator->errors()->first(), position: "center");
        } catch (\Exception $ex) {
            $this->dispatch('alert', icon: "error", title: "Erro Inesperado", text: $ex->getMessage(), position: "center");
        }
    }

    public function submitFormPersonalInfo()
    {
        try {
            $this->validate();

            $formData = [];
            $genericCtrl = new GenericCtrl("Person");

            // Aplica as funções de salvamento aos dados do formulário
            $this->applySaveFunctions($formData);

            $genericCtrl->update(auth()->user()->getPerson->pes_id, $formData);

            $this->dispatch('alert', icon: "success", title: "Sucesso!", position: "center");
            $this->js("window.refresh()");
        } catch (\Illuminate\Validation\ValidationException $ex) {
            $this->dispatch('alert', icon: "error", title: "Erro no Formulário", text: $ex->validator->errors()->first(), position: "center");
        } catch (\Exception $ex) {
            $this->dispatch('alert', icon: "error", title: "Erro Inesperado", text: $ex->getMessage(), position: "center");
        }
    }

    public function render()
    {
        return view('livewire.profile-screen');
    }
}
