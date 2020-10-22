<?php


    namespace App\Models;
    use MF\Model\Model;
    class User extends Model{
        private $id;
        private $id_user_follow;
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

        //authenticate

        public function authUser(){
            try{
                $query = "SELECT _name ,id,_email FROM users WHERE _email = :_email AND _password = :_password";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":_email",$this->__get("email"));
                $stmt->bindValue(":_password",$this->__get("password"));
                $stmt->execute();
                $user = $stmt->fetch(\PDO::FETCH_OBJ);
                //if the user exists in db we'll set this obj's attrs 
                if(is_object($user) && $user->id != '' && $user->_name != '' ){
                    $this->__set('id',$user->id);
                    $this->__set('name',$user->_name);
                }
                return $this;
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
           
        }
        //Search for
        public function getAll(){
            $query = "SELECT _name,id,_email FROM users WHERE _name LIKE :_name AND id <> :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":_name",'%'.$this->__get('name').'%');
            $stmt->bindValue(":id",$this->__get('id'));
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        //follow
        public function follow(){
            try{
                //check if this user is already following him
                $query = "SELECT id FROM users_followers WHERE id_user = :id AND id_user_followed = :id_user_followed";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id",$this->__get("id"));
                $stmt->bindValue(":id_user_followed",$this->__get("id_user_follow"));
                $stmt->execute();
                $acess =  $stmt->rowCount(); // if the returns is 1 it means that this user is already following
                //if he is not following we will follow
                if(!($acess)){
                    $query = "INSERT INTO users_followers(id_user, id_user_followed)VALUES(:id, :id_user_followed)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindValue(":id",$this->__get("id"));
                    $stmt->bindValue(":id_user_followed",$this->__get("id_user_follow"));
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
    }
?>