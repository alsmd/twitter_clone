<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
use App\Connection;

class AppController extends Action{
    
    

    public function isLogged(){
        //if the user isn't logged in he'll go to the main page
        if((!(isset($_SESSION['id'])) || $_SESSION['id'] == '') || (!(isset($_SESSION['name'])) || $_SESSION['name'] = '' )){
            header('Location: /?login=erro');
        }
    }
    public function timeline(){
        $this->isLogged();
        //get all use's informations
        $perfil =  Container::getModel('perfil');
        $this->view->perfil = $perfil;
        //Getting all the tweets
        $this->render('timeline');
    }
    public function tweetsPags(){
        $this->isLogged();
        $tweet =  Container::getModel('tweet');
        $tweet->__set('id_user',$_SESSION['id']);
        $pag = isset($_POST['pag']) ? $_POST['pag'] : 0;
        //saving new tweet
        if(isset($_POST['tweet']) && $_POST['tweet'] != ''){
            $tweet->__set("tweet",$_POST['tweet']);
            $tweet->__set("id_user",$_SESSION['id']); //Using the id of the user who is logged in to add a new tweet linked to him in the database
            $tweet->save();
        }
        //pagination's variables
        if($pag != 0) $pag -= 1; //current page
        $total_tweets = $tweet->getTotalTweets()->total;
        $total_per_pag = 5;
        $displacement = $pag * $total_per_pag;
        $total_pag = ceil($total_tweets / $total_per_pag);
        $tweets = $tweet->getPerPage($total_per_pag,$displacement);
        $tweets['total_pag'] = $total_pag;
        echo json_encode($tweets);

    }

    
    //delete tweet
    public function delete_tweet(){
        $this->isLogged();
        if(!(isset($_POST['tweet_id']))) header('Location: /timeline');
        $tweet = Container::getModel('tweet');
        $tweet->__set("id",$_POST['tweet_id']);
        $tweet->__set("id_user",$_SESSION['id']);
        $tweet->remove();
    }

    public function who_follow(){
        $this->isLogged();
        //get all use's informations
        $perfil =  Container::getModel('perfil');
        $this->view->perfil = $perfil;
        $users = [];
        $user = Container::getModel('user');
        $user->__set('id',$_SESSION['id']);
        $this->view->searchFor = $user->getAllUsers();

        $this->render('who_follow');
    }
    public function who_follow_search(){
        $this->isLogged();
        if($_POST['action'] == "all"){
            $user = Container::getModel('user');
            $user->__set('id',$_SESSION['id']);
            $users = $user->getAllUsers(); 
            echo json_encode($users);
        }else if($_POST['action'] == 'only_searched'){
            $for = isset($_POST['name']) ? $_POST['name'] : '';
            $user = Container::getModel('user');
            if($for != ''){
                $user->__set('name',$for);
                $user->__set('id',$_SESSION['id']);
                $users = $user->getAll(); //Get all users that corresponds with the string that was send
                echo json_encode($users);
            }else if($for == ''){
                $user = Container::getModel('user');
                $user->__set('id',$_SESSION['id']);
                $users = $user->getAllUsers(); 
                echo json_encode($users);
            }
        }
        
    }

    public function action(){
        $this->isLogged();
        $user = Container::getModel('UsersFollowers');
        $user->__set('id_user',$_SESSION['id']);
        $action = isset($_POST['action']) ? $_POST['action']: '';
        //follow 
        if($action == 'follow'){
            
            $user->__set('id_user_followed',$_POST['id']);
            $acess = $user->follow();
            if($acess == 1){ //follow success
                echo "follow=true";
            }
            if($acess == 'following'){ //user is alredy following
                echo "follow=following";
            }
        }
        //unfollow
        if($action == 'unfollow'){
            
            $user->__set('id_user_followed',$_POST['id']);
            $acess = $user->unfollow();
            if($acess == 1){ //unfollow success
               echo "unfollow=true";
            }else{ //unfollow error
                echo "unfollow=false";
            }
        }
    }

    
}

?>