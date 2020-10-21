<?php

namespace App\Controllers;
//Models
use App\Models\User;
//Recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{
    public function index(){
        $this->view->login = isset($_GET['login']) ?  $_GET['login'] : '';
        $this->render('index','layout');
    }
    public function inscreverse(){
        $this->view->user = array(
            'name' => '',
            'email' => '',
            'password' => ''

        );
        $this->view->erroRegister = false;
        $this->render('inscreverse','layout');
    }

    public function register(){
        ///set data into class user
        $user = Container::getModel('User');
        $user->__set('name',$_POST['name']);
        $user->__set('email',$_POST['email']);
        $user->__set('password',$_POST['password']); 

        //if the fields are correct
        if($user->validateRegister()){
            //if user doesn't alredy exist
            if(count($user->getUserByEmail()) == 0){
                //success
                $user->save();
                $this->render('register');
            }else{
                //user does alredy exist
                $this->render('email_alredy_exists');
            }

        }else{
            //error if any of the fields are incorrect
            $this->view->user = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password']

            );
            $this->view->erroRegister = true;
            $this->render('inscreverse');
        }
    }
    

}


?>