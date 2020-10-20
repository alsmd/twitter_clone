<?php

namespace App\Controllers;
//Models
use App\Models\User;
//Recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{
    public function index(){
        $this->render('index','layout');
    }
    public function inscreverse(){
        $this->render('inscreverse','layout');
    }

    public function register(){
        ///set data into class user
        $user = Container::getModel('User');
        $user->__set('name',$_POST['name']);
        $user->__set('email',$_POST['email']);
        $user->__set('password',$_POST['password']); 

        //if user doesn't exist
        if(count($user->getUserByEmail()) == 0){
            //success
            $user->save();
            $this->render('register','layout');
        }else{
            //error
            $this->render('register_erro','layout');
        }
    }
    

}


?>