<?php 

namespace App\Controllers;

use App\Controllers\Utils\TripleDES;
use Illuminate\Support\Facades\Session;

class UserCtrl extends GenericCtrl {
    public $model = "User";
    protected $tripleDES;

    public function __construct() {
        parent::__construct($this->model);
        $this->tripleDES = new TripleDES();
    }

    public function buildUserPermissionsInSession($userId) {
        try {
            $user = $this->getObject($userId);

            $usrPermissions = array();
            foreach ($user->permissions as $key => $value) {
                $usrPermissions[$value->usp_area][$value->usp_action] = true;
            }

            Session::put('usr_permissions', $usrPermissions);
        } catch (\Throwable $ex) {
            return array(
                "status" => false,
                "message" => $ex->getMessage()
            );
        }
    }

    /**
     * @param int $userId
     * @param string $oldPassword
     * @param string $newPassword
     * 
     * @return array
     */
    public function updateUserPassword($userId, $oldPassword, $newPassword) {
        try {
            $criptedPassword = $this->tripleDES->encrypt($newPassword);
            $user = $this->getObject($userId);

            if($this->tripleDES->decrypt($user->usr_password) != $oldPassword) {  
                return array(
                    "status" => false,
                    "message" => "A senha atual está incorreta...",
                );
            }   

            $this->update($userId, array(
                "usr_password" => $criptedPassword,
            ));

            return array(
                "status" => true,
                "message" => "Senha atualizada com sucesso!",
            );
        } catch (\Throwable $ex) {
            return array(
                "status" => false,
                "message" => "Erro Inesperado ao Alterar a Senha"
            );
        }
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