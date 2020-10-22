<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{
    
    

    public function isLogged(){
        //if the user isn't logged in he'll go to the main page
        if((!(isset($_SESSION['id'])) || $_SESSION['id'] == '') || (!(isset($_SESSION['name'])) || $_SESSION['name'] = '' )){
            header('Location: /?login=erro');
        }
    }
    public function timeline(){
        $this->isLogged();
        //Getting all the tweets
        $tweet =  Container::getModel('tweet');
        $tweet->__set('id_user',$_SESSION['id']);
        $this->view->tweets = $tweet->getAll();
        $this->render('timeline');
    }
    public function tweet(){
        $this->isLogged();
        $tweet = Container::getModel('tweet');
        $tweet->__set("tweet",$_POST['tweet']);
        $tweet->__set("id_user",$_SESSION['id']); //Using the id of the user who is logged in to add a new tweet linked to him in the database
        $tweet->save();
        header("Location: /timeline");
    } 
    
    public function who_follow(){
        $this->isLogged();
        $users = [];
        $for = isset($_GET['name']) ? $_GET['name'] : '';
        $user = Container::getModel('user');
        if($for != ''){
            $user->__set('name',$for);
            $user->__set('id',$_SESSION['id']);
            $users = $user->getAll(); //Get all users that corresponds with the string that was send
            $this->view->searchFor = $users;
        }
        if(!(isset($_GET['name'])) ||$_GET['name'] == '' ){
            $user->__set('id',$_SESSION['id']);
            $this->view->searchFor = $user->getAllUsers();
        }

        $this->render('who_follow');
    }

    public function action(){
        $this->isLogged();
        $user = Container::getModel('UsersFollowers');
        $user->__set('id_user',$_SESSION['id']);
        $action = isset($_GET['action']) ? $_GET['action']: '';
        //follow 
        if($action == 'follow'){
            
            $user->__set('id_user_followed',$_GET['id']);
            $acess = $user->follow();
            if($acess == 1){ //follow success
                header("Location: /who_follow?follow=true");
            }
            if($acess == 'following'){ //user is alredy following
                header("Location: /who_follow?follow=following");
            }
        }
        //unfollow
        if($action == 'unfollow'){
            
            $user->__set('id_user_followed',$_GET['id']);
            $acess = $user->unfollow();
            if($acess == 1){ //unfollow success
                header("Location: /who_follow?unfollow=true");
            }else{ //unfollow error
                header("Location: /who_follow?unfollow=false");
            }
        }
        

    }
}

?>