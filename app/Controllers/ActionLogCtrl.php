<?php 
    namespace App\Controllers;

    class ActionLogCtrl extends GenericCtrl{
        public $model = "ActionLog";

        public function __construct() {
            parent::__construct($this->model);
        }

        static public function addLogInSystem($local, $action, $object, $identifier) {
            try {
                $instance = new self();

                $messages = array(
                    "Insert" => "Inclusão de novo Registro",
                    "Edit" => "Edição de Registro",
                    "Delete" => "Remoção de Registro"
                );

                $instance->save(array(
                    "alg_model" => $local,
                    "alg_action" => $action,
                    "alg_description" => $messages[$action],
                    "alg_object" => json_encode($object),
                    "alg_date" => date("Y-m-d"),
                    "alg_time" => date("H:i:s"),
                    "alg_model_id" => $identifier,
                    "users_usr_id" => auth()->user()->usr_id,
                ));
            } catch (\Throwable $ex) {
                dd($ex->getMessage());
            }
        }
    }