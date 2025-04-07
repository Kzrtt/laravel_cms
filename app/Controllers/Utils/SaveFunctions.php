<?php

namespace App\Controllers\Utils;

use App\Controllers\Utils\TripleDES;

class SaveFunctions {
    static function encrypt($data) {
        $tripleDES = new TripleDES();
        return $tripleDES->encrypt($data);
    }

    static function stringToTime($data) {
        // Divide a string em horas e minutos
        list($hours, $minutes) = explode(':', $data);

        // Converte para inteiro (para garantir que não haja zeros à esquerda indesejados)
        $hours   = intval($hours);
        $minutes = intval($minutes);

        // Formata a string para HH:MM:SS, definindo os segundos como 00
        return sprintf('%02d:%02d:%02d', $hours, $minutes, 0);
    }
}