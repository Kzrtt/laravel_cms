<?php 
    namespace App\Controllers;

    class GenericCtrl {
        var $model = "";

        public function __construct($model = "") {
            $this->model = app("App\\Models\\".$model);
        }

        public function delete($id) {
            $registry = $this->model::findOrFail($id);
            return $registry->delete();
        }
    }
?>