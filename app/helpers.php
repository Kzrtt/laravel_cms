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
                "required" => "O :attribute é obrigatório",
                "min" => "O :attribute precisa ter no mínimo :min caracteres"
            );

            return isset($validationMap[$rule]) ? $validationMap[$rule] : "Erro no campo :attribute";
        }
    }
?>