<?php


    namespace App\Models;
    use MF\Model\Model;
    class User extends Model{
        private $id;
        private $name;
        private $email;
        private $password;

        public function __get($attr){
            return $this->$attr;
        }
        public function __set($attr,$value){
            $this->$attr = $value;
            return $this;
        }


        //save
        public function save(){
            try{
                $query = "INSERT INTO users(_name ,_email, _password )VALUES(:_name, :_email, :_password)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':_name',$this->__get('name'));
                $stmt->bindValue(':_email',$this->__get('email'));
                $stmt->bindValue(':_password',$this->__get('password')); //md5 hash 32 caracteres
                $stmt->execute();

                return $this;
            }catch(\PDOException $e){
                echo 'Moio, deu erro';
            }
            

        }


        //validate if registration can be done

        public function validateRegister(){
            $acess = true;
            // name, email and password's length have to be higher than 3
            $email = explode('@',$this->__get('email'))[0];
            if(strlen($this->__get('name')) < 3 || strlen($email ) < 3 || strlen($this->__get('password')) < 3 ){
                $acess = false;
            }
            return $acess;
        }
        //get user by email
        public function getUserByEmail(){
            $query = "SELECT * FROM users WHERE _email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":email", $this->__get('email'));
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>