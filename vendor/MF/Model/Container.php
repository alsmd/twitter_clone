<?php
namespace MF\Model;

use App\Connection;
class Container{
    //criando os models de forma dinamica
    public static function getModel($model){
        $conn = Connection::getDb(); 
        $class = "\\App\\Models\\". ucfirst($model);
        return new $class($conn);
    }
}



?>