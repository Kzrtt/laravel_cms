<?php
    namespace App\Controllers;

    class IngredientCtrl extends GenericCtrl {
        public $model = "Ingredient";

        public function __construct() {
            parent::__construct($this->model);
        }

        public function saveIngredient($data) {
            $data['establishment_est_id'] = session("est_id");
            $registry = $this->save($data);
            return $registry;
        }
    }
?>