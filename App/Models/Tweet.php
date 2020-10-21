<?php
    namespace App\Models;
    use MF\Model\Model;


    class Tweet extends Model{
        private $id;
        private $id_user;
        private $tweet;
        private $date;

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
                return $this;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }

        //get
    }
?>