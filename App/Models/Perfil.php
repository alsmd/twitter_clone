<?php


    namespace App\Models;
    use MF\Model\Model;
    class Perfil extends Model{
        private $id;
        public $name;
        public $total_tweets;
        public $total_following;
        public $total_followers;
        private $execute = true; //this attr will be used to indicate whether the "construct" method will be executed at the time of the instance

        public function construct(){ //Get all informations about the user that is logged in
            $this->id = $_SESSION['id'];
            $this->getInformations();
            $this->getTotalFollowers();
            $this->getTotalFollowing();
            $this->getTotalTweets();
        }
        public function __get($attr){
            return $this->$attr;
        }
        public function __set($attr,$value){
            $this->$attr = $value;
            return $this;
        }
        //Get informatins about the user
        public function getInformations(){
            $query = "SELECT _name from users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get('id'));
            $stmt->execute();
            $return = $stmt->fetch(\PDO::FETCH_OBJ);
            $this->__set("name",$return->_name);
        }
        //Total of people that are following him
        public function getTotalFollowers(){
            $query = "
            SELECT
                COUNT(id_user) as total
            FROM
                users_followers
            WHERE
                id_user_followed = :id
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get('id'));
            $stmt->execute();
            $this->__set("total_followers",$stmt->fetch(\PDO::FETCH_OBJ)->total);
        }
        //Total of people that he is following
        public function getTotalFollowing(){
            $query = "
            SELECT
                COUNT(id_user_followed) as total
            FROM
                users_followers
            WHERE
                id_user = :id
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get('id'));
            $stmt->execute();
            $this->__set("total_following",$stmt->fetch(\PDO::FETCH_OBJ)->total);
        }
        //total of tweets made by him
        public function getTotalTweets(){
            $query = "
            SELECT
                COUNT(id) as total
            FROM
                tweets
            WHERE
                id_user = :id
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get('id'));
            $stmt->execute();
            $this->__set("total_tweets",$stmt->fetch(\PDO::FETCH_OBJ)->total);
        }
    }

?>