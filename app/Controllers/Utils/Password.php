<?php

namespace App\Controllers\Utils;

class Password {

    var $caracter = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "m", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

    /**
     * Criptografa uma string convertendo os caracteres alfanumericos em c�digos da tabela ASCII
     *
     * @param String $string     String a ser convertida
     * @return String
     */
    public function cript($senha) {
        $stringASC = "";
        for ($i = 0; $i < strlen($senha); $i++) {
            $asc = substr($senha, $i, 1);
            $asc = (ord($asc) * 8 / 4) + 38;
            $rnd = rand(0, 51);
            $stringASC .= zeroFill($asc, 3);
            $stringASC .= $this->caracter[$rnd];
        }
        return $stringASC;
    }


    
    /**
     * Descriptografa uma string convertendo os caracteres ASCII em c�digos alfanumericos
     *
     * @param String $string     String a ser convertida
     * @return String
     */
    public function deCript($string) {
        $stringASC = "";
        for ($j = 0; $j < count($this->caracter); $j++) {
            $string = str_replace($this->caracter[$j], "", $string);
        }
        $nroCaracteres = strlen($string) / 3;
        for ($i = 0; $i < $nroCaracteres; $i++) {

            $inicio = $i * 3;
            $fim = $inicio + 3;
            $asc = substr($string, $inicio, 3);

            $asc = ($asc - 38) * 4 / 8;
            $carac = chr($asc);
            $stringASC .= $carac;
        }
        return $stringASC;
    }

}

?>