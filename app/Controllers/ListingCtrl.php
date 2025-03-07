<?php 
    namespace App\Controllers;

    class ListingCtrl {
        public $model = "";
        public $entity;

        public function __construct($model) {
            $this->model = $model;
            $this->entity = "App\\Models\\".$this->model;
        }

        public function getAll() {
            return $this->entity::select()->get();
        }
    }
?>