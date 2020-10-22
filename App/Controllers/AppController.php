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
        $this->view->searchFor = [];
        $for = isset($_GET['name']) ? $_GET['name'] : '';
        if($for != ''){
            $user = Container::getModel('user');
            $user->__set('name',$for);
            $user->__set('id',$_SESSION['id']);
            $this->view->searchFor = $user->getAll(); //Get all users that corresponds with the string that was send
        }
        $this->render('who_follow');
    }
}

?>