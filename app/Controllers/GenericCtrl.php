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

        public function update($id, $data) {
            $registry = $this->getObject($id);
            $registry->update($data);

            return $registry;
        }

        public function getAll() {
            return $this->model::select()->get();
        }

        /**
         * @return object
         */
        public function getObjectByField($field, $value, $first=true) {
            if($first) {
                return $this->model::where($field, $value)->first();
            } else {
                return $this->model::where($field, $value)->get();
            }
        }

        /**
         * @return object
         */
        public function getObjectByFields(array $fields, array $values, $first=true) {        
            $query = $this->model::query();
        
            foreach ($fields as $index => $field) {
                $query->where($field, $values[$index]);
            }
            
            return $first ? $query->first() : $query->get();
        }

        /**
         * @return object
         */
        public function getObject($id) {
            return $this->model::find($id);
        }

        public function delete($id) {
            $registry = $this->model::findOrFail($id);
            return $registry->delete();
        }

        public function getRemoteData($value, $remoteConfig) {
            $remoteEntity = app("App\\Models\\".$remoteConfig['remoteEntity']);
        
            $remoteData = $remoteEntity::where(
                $remoteConfig['remoteAtrr'], 
                $value,
            )->pluck($remoteConfig['value'], $remoteConfig['key'])->toArray();

            return $remoteData;
        }
    }
?>