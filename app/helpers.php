<?php 
    if(!function_exists("prettyPrint")) {
        function prettyPrint($data) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
    }
?>