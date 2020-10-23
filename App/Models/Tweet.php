<?php
    namespace App\Models;
    use MF\Model\Model;


    class Tweet extends Model{
        private $id;
        private $id_user;
        public $tweet;
        public $date;
        private $execute = false;
        public function __get($attr){
            return $this->$attr;
        }
        public function __set($attr, $value){
            $this->$attr = $value;
            return $this;
        }

        //save
        public function save(){
            try{
                $query = "INSERT INTO tweets (id_user, tweet)VALUES(:id_user, :tweet)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id_user",$this->__get('id_user'));
                $stmt->bindValue(":tweet",$this->__get('tweet'));
                $stmt->execute();
                return $stmt->rowCount();
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }

        //get All

        public function getPerPage($limit,$offset){
            $query = "SELECT

             t.id,t.id_user, t.tweet,u._name, DATE_FORMAT(t.date,'%d/%m/%Y %H:%i') as date

             FROM 
             tweets as t LEFT JOIN users as u ON(t.id_user = u.id)
             WHERE
             t.id_user = :id_user
             or t.id_user IN(SELECT id_user_followed from users_followers where id_user = :id_user)
             ORDER BY
             t.date DESC
             LIMIT
             $offset,$limit
             ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_user", $this->id_user);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        public function getTotalTweets(){
            $query = "SELECT

             COUNT(*) as total

             FROM 
             tweets as t LEFT JOIN users as u ON(t.id_user = u.id)
             WHERE
             t.id_user = :id_user
             or t.id_user IN(SELECT id_user_followed from users_followers where id_user = :id_user)
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_user", $this->id_user);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
           
        }
        public function remove(){
            try{
                $query = "DELETE FROM tweets WHERE id = :id and id_user = :id_user ";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id',$this->__get("id"));
                $stmt->bindValue(':id_user',$this->__get("id_user"));
                $stmt->execute();
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>