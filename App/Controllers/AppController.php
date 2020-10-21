<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{

    public function isLogged(){
        //if the user isn't logged in he'll go to the main page
        if(!(isset($_SESSION['id'])) || !(isset($_SESSION['name']))){
            header('Location: /?login=erro');
        }
    }
    public function timeline(){
        $this->isLogged();
        $this->render('timeline');
    }
    public function tweet(){
        $this->isLogged();
        $tweet = Container::getModel('tweet');
        $tweet->__set("tweet",$_POST['tweet']);
        $tweet->__set("id_user",$_SESSION['id']); //Using the id of the user who is logged in to add a new tweet linked to him in the database
        $tweet->save();
    }


}

?>