<?php

namespace App\Controllers\Utils;

use App\Controllers\Utils\Password;

class TripleDES {

private $encrypt_method = "AES-256-CBC";
private $secret_key = '9iu07dzd4os2la8ze6h525tg';
private $secret_iv = 'qk1ggwng5963dw67apzmpxcu';


/**
 * Criptografa uma string de acordo com as chaves especificadas
 * 
 * @param string $data
 * @return string
 */
function encrypt($data) {
    $passwordImaxis = new Password();
    $key = hash('sha256', $this->secret_key);
    $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    $output = openssl_encrypt($data, $this->encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $passwordImaxis->cript($output);
}


/**
 * Descriptografa uma string utilizando as as chaves especificadas
 * 
 * @param string $data
 * @return string
 */
function decrypt($data) {
    $passwordImaxis = new Password();
    $data = $passwordImaxis->deCript($data);
    $key = hash('sha256', $this->secret_key);
    $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    return openssl_decrypt(base64_decode($data), $this->encrypt_method, $key, 0, $iv);
}


/**
 * Criptografa um uma string utilizando um método randomico
 * 
 * @param string $token
 * @return string
 */
function encryptToken($token) {
    $crypted = "";
    $array = array(
        "0" => array("3", "9", "6", "5", "4", "1", "8", "7", "2", "0"),
        "1" => array("0", "3", "9", "6", "5", "4", "1", "8", "7", "2"),
        "2" => array("2", "0", "3", "9", "6", "5", "4", "1", "8", "7"),
        "3" => array("7", "2", "0", "3", "9", "6", "5", "4", "1", "8"),
        "4" => array("8", "7", "2", "0", "3", "9", "6", "5", "4", "1"),
        "5" => array("1", "8", "7", "2", "0", "3", "9", "6", "5", "4"),
        "6" => array("4", "1", "8", "7", "2", "0", "3", "9", "6", "5"),
        "7" => array("5", "4", "1", "8", "7", "2", "0", "3", "9", "6"),
        "8" => array("6", "5", "4", "1", "8", "7", "2", "0", "3", "9"),
        "9" => array("9", "6", "5", "4", "1", "8", "7", "2", "0", "3"),
    );
    for ($i = 0; $i < strlen($token); $i++) {
        $arrayCrypted = $array[substr($token, $i, 1)];
        $digit = $arrayCrypted[$i];
        $crypted .= $digit;
    }
    return $crypted;
    $crypted = "";
    $array = array(
        "0" => array("3", "9", "6", "5", "4", "1", "8", "7", "2", "0"),
        "1" => array("0", "3", "9", "6", "5", "4", "1", "8", "7", "2"),
        "2" => array("2", "0", "3", "9", "6", "5", "4", "1", "8", "7"),
        "3" => array("7", "2", "0", "3", "9", "6", "5", "4", "1", "8"),
        "4" => array("8", "7", "2", "0", "3", "9", "6", "5", "4", "1"),
        "5" => array("1", "8", "7", "2", "0", "3", "9", "6", "5", "4"),
        "6" => array("4", "1", "8", "7", "2", "0", "3", "9", "6", "5"),
        "7" => array("5", "4", "1", "8", "7", "2", "0", "3", "9", "6"),
        "8" => array("6", "5", "4", "1", "8", "7", "2", "0", "3", "9"),
        "9" => array("9", "6", "5", "4", "1", "8", "7", "2", "0", "3"),
    );
    for ($i = 0; $i < strlen($token); $i++) {
        $arrayCrypted = $array[substr($token, $i, 1)];
        $digit = $arrayCrypted[$i];
        $crypted .= $digit;
    }
    return $crypted;
}


/**
 * Descriptografa um uma string utilizando um método randomico
 * 
 * @param string $token
 * @return string
 */
function decryptToken($token) {
    $decrypted = "";
    $array = array(
        "0" => array("3", "9", "6", "5", "4", "1", "8", "7", "2", "0"),
        "1" => array("0", "3", "9", "6", "5", "4", "1", "8", "7", "2"),
        "2" => array("2", "0", "3", "9", "6", "5", "4", "1", "8", "7"),
        "3" => array("7", "2", "0", "3", "9", "6", "5", "4", "1", "8"),
        "4" => array("8", "7", "2", "0", "3", "9", "6", "5", "4", "1"),
        "5" => array("1", "8", "7", "2", "0", "3", "9", "6", "5", "4"),
        "6" => array("4", "1", "8", "7", "2", "0", "3", "9", "6", "5"),
        "7" => array("5", "4", "1", "8", "7", "2", "0", "3", "9", "6"),
        "8" => array("6", "5", "4", "1", "8", "7", "2", "0", "3", "9"),
        "9" => array("9", "6", "5", "4", "1", "8", "7", "2", "0", "3"),
    );
    for ($i = 0; $i < strlen($token); $i++) {
        for ($k = 0; $k < count($array); $k++) {
            if ($array[$k][$i] == substr($token, $i, 1)) {
                $decrypted .= $k;
            }
        }
    }
    return $decrypted;
}



/**
 * Cria uma senha randomica
 * 
 * @param integer $size
 * @param boolean $hasUpperChars
 * @param boolean $hasLowerChars
 * @param boolean $hasNumbers
 * @param boolean $hasSymbols
 * @return string
 */
function createPassword($size = 6, $hasUpperChars = true, $hasLowerChars = true, $hasNumbers = true, $hasSymbols = false) {
    $upper = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; 
    $lower = "abcdefghijklmnopqrstuvyxwz"; 
    $numbers = "0123456789"; 
    $symbols = "!@#$%¨&*()_+="; 
    $password = '';
    if ($hasUpperChars) {
        $password .= str_shuffle($upper);
    }
    if ($hasLowerChars) {
        $password .= str_shuffle($lower);
    }
    if ($hasNumbers) {
        $password .= str_shuffle($numbers);
    }
    if ($hasSymbols) {
        $password .= str_shuffle($symbols);
    }
    return $this->encrypt(substr(str_shuffle($password), 0, $size));
}
}