<?php

namespace App\Controllers\Utils;

use App\Controllers\Utils\TripleDES;

class SaveFunctions {
    static function encrypt($data) {
        $tripleDES = new TripleDES();
        return $tripleDES->encrypt($data);
    }
}