<?php 
    namespace App\Controllers;

    class GenericCtrl {
        var $model = "";

        public function __construct($model = "") {
            $this->model = app("App\\Models\\".$model);
        }

        public function save($data) {
            $registry = $this->model::create($data);
            return $registry;
        }

        public function getObject($id) {
            return $this->model::find($id);
        }

        public function getAll() {
            return $this->model::select()->get();
        }

        public function getRemoteData($value, $remoteConfig) {
            $remoteEntity = app("App\\Models\\".$remoteConfig['remoteEntity']);
        
            $remoteData = $remoteEntity::where(
                $remoteConfig['remoteAtrr'], 
                $value,
            )->pluck($remoteConfig['value'], $remoteConfig['key'])->toArray();

            return $remoteData;
        }

        public function delete($id) {
            $registry = $this->model::findOrFail($id);
            return $registry->delete();
        }
    }
?>