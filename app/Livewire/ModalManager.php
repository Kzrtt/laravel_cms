<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Controllers\GenericCtrl;

class ModalManager extends Component
{
    public $modalArray = array(
        "recipeDetailsModal" => false,
        "selectEstablishmentModal" => false,
    );

    public $params = array(
        "recipe" => null,
        "selectEstablishmentModal" => array(
            "establishments" => [],
            "redirectTo" => "",
            "local" => ""
        ),
    );

    public $selectedEstablishment = "";

    #[On('openModal')]
    public function openModal($params)
    {
        $modal = $params['modal'];
        $this->modalArray[$modal] = true;

        if($modal == "recipeDetailsModal") {
            $recipeCtrl = new GenericCtrl("Recipe");
            $recipe = $recipeCtrl->getObject($params['id']);

            $this->params['recipe'] = $recipe;
        } else if($modal == "selectEstablishmentModal") {
            $establishmentCtrl = new GenericCtrl("Establishment");
            $establishments = $establishmentCtrl->getAll();

            $this->params['selectEstablishmentModal']['redirectTo'] = $params['viewForm'];
            $this->params['selectEstablishmentModal']['local'] = $params['local'];
            $this->params['selectEstablishmentModal']['establishments'] = $establishments;
        }
    }

    public function redirectTo() {
        $params = $this->params['selectEstablishmentModal'];

        session()->put('est_id', $this->selectedEstablishment);
        return redirect()->route($params['redirectTo'], ["local" => $params['local']]);
    }

    public function render()
    {
        return view('livewire.modal-manager');
    }
}
