<?php 

namespace App\Controllers;

use App\Controllers\Utils\TripleDES;

class UserCtrl extends GenericCtrl {
    public $model = "User";
    protected $tripleDES;

    public function __construct() {
        parent::__construct($this->model);
        $this->tripleDES = new TripleDES();
    }

    /**
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function validateLogin($email, $password) {
        $user = $this->getObjectByField("usr_email", $email);

        if(!$user instanceof $this->model) {
            return array(
                "status" => false,
                "message" => "Usuário não encontrado na base de dados...",
            );
        }
        
        if($password != $this->tripleDES->decrypt($user->usr_password)) {
            return array(
                "status" => false,
                "message" => "Senha incorreta...",
            );
        }

        return array(
            "status" => true,
            "message" => "Login efetuado com sucesso!",
            "user" => $user,
        );
    }
}