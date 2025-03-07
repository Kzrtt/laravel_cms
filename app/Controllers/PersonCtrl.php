<?php
    namespace App\Controllers;

    class PersonCtrl {
        public $model = "App\\Models\\Person";

        public function getAllPersons() {
            return $this->model::select()->get()->pluck('pes_name', 'pes_id')->toArray();
        }
    }
?>