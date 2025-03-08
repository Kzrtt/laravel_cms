<?php 
    if(!function_exists("prettyPrint")) {
        function prettyPrint($data) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
    }

    if(!function_exists("getMessageForValidation")) {
        function getMessageForValidation($rule) {            
            $validationMap = array(
                "required" => "O Campo :attribute é obrigatório",
                "min" => "O Campo :attribute precisa ter no mínimo :min caracteres"
            );

            return isset($validationMap[$rule]) ? $validationMap[$rule] : "Erro no campo :attribute";
        }
    }

    if(!function_exists("getFriendlyPermission")) {
        function getFriendlyPermission($permission) {
            $permissionMap = array(
                "Consult" => "Consultar",
                "Insert" => "Inserir",
                "Delete" => "Deletar",
                "Edit" => "Edição",
            );

            return isset($permissionMap[$permission]) ? $permissionMap[$permission] : "?";
        }
    }

?>