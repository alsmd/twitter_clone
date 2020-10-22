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
    
    //delete tweet
    public function delete_tweet(){
        $this->isLogged();
        if(!(isset($_POST['tweet_id']))) header('Location: /timeline');
        $query = "DELETE FROM tweets WHERE id = :id and id_user = :id_user ";
        $con = Connection::getDb();
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id',$_POST['tweet_id']);
        $stmt->bindValue(':id_user',$_SESSION['id']);
        $stmt->execute();
    }

    public function who_follow(){
        $this->isLogged();
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