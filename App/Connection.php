<?php 

namespace App;

class Connection{

    //responsavel por criar conexao com o banco
    public static function getDb(){
        try{
            $conn = new \PDO(
                "mysql:host=localhost;dbname=twitter_clone;charset=utf8",
                "root",
                ""
            );

            return $conn;
        }catch(\PDOException $e){
            //... tratar de alguma forma ...//
            echo 'deu erro instanciar a conexao';
        }
    }
}


?>