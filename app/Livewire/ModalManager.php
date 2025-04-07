<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Controllers\GenericCtrl;

class ModalManager extends Component
{
    public $modalArray = array(
        "recipeDetailsModal" => false,
    );

    public $params = array(
        "recipe" => null,
    );

    #[On('openModal')]
    public function openModal($params)
    {
        $modal = $params['modal'];
        $this->modalArray[$modal] = true;

        if($modal == "recipeDetailsModal") {
            $recipeCtrl = new GenericCtrl("Recipe");
            $recipe = $recipeCtrl->getObject($params['id']);

            $this->params['recipe'] = $recipe;
        }
    }

    public function render()
    {
        return view('livewire.modal-manager');
    }
}
