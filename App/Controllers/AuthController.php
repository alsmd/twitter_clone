<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
class AuthController{


    public function authenticate(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        $user = Container::getModel("user");
        $user->__set('email',$_POST['email']);
        $user->__set('password',$_POST['password']);
        $user_true = $user->authUser();
        echo '<pre>';
        print_r($user_true);
        echo '</pre>';
        if($user_true){
            echo 'acesso permitido';
        }else{
            echo 'acesso negado';
        }
    }
    public function logoff(){

    }

}

?>