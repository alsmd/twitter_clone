<?php 

    namespace App\Models;
    use MF\Model\Model;


    class UsersFollowers extends Model{
        private $id;
        private $id_user;
        private $id_user_followed;


        public function __get($attr){
            return $this->$attr;
        }
        public function __set($attr,$value){
            $this->$attr = $value;
            return $this;
        }
    //follow
    public function follow(){
        try{
            //check if this user is already following him
            $query = "SELECT id FROM users_followers WHERE id_user = :id AND id_user_followed = :id_user_followed";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get("id_user"));
            $stmt->bindValue(":id_user_followed",$this->__get("id_user_followed"));
            $stmt->execute();
            $acess =  $stmt->rowCount(); // if the returns is 1 it means that this user is already following
            //if he is not following we will follow
            if(!($acess)){

                $query = "INSERT INTO users_followers(id_user, id_user_followed)VALUES(:id, :id_user_followed)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id",$this->__get("id_user"));
                $stmt->bindValue(":id_user_followed",$this->__get("id_user_followed"));
                $stmt->execute();
                return $stmt->rowCount();

            }else{
                return 'following'; // else we'll warn that this users is already following
            }
            
        }catch(\PDOException $e){
            echo 'Erro follow : '. $e->getMessage();
        }
    }


    //unfollow
    public function unfollow(){
        try{
            //Delete the follow and followed relationship the users
            $query = "DELETE FROM users_followers WHERE id_user = :id AND id_user_followed = :id_user_followed";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id",$this->__get("id_user"));
            $stmt->bindValue(":id_user_followed",$this->__get("id_user_followed"));
            $stmt->execute();
            return $stmt->rowCount();
        }catch(\PDOException $e){
            echo 'Erro follow : '. $e->getMessage();
        }
    }
    }
?>