<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
class AuthController{


    public function authenticate(){
        $user = Container::getModel("user");
        $user->__set('email',$_POST['email']);
        $user->__set('password',$_POST['password']);
        $user->authUser();
        //if id and name is diferent of ''(null,false) it means that there is a register of this user in my db
        //so the auth is true
        if($user->__get('id') != '' && $user->__get('name') != ''  ){
            session_start();
            $_SESSION['id'] = $user->__get("id");
            $_SESSION['name'] = $user->__get("name");
            header('Location: /timeline');

        }else{
            header('Location: /?login=erro');
        }
    }
    public function logoff(){

    }

}

?>