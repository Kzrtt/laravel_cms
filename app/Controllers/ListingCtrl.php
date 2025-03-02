<?php 
    namespace App\Controllers;

    class ListingCtrl {
        public function getAll($local) {
            $entity = "App\\Models\\".$local;
            return $entity::all();
        }
    }
?>