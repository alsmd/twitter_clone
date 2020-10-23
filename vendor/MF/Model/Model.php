<?php 

namespace MF\Model;

abstract class Model{
    protected $db;

    public function __construct(\PDO $db){
        $this->db = $db;
        if($this->execute){ //if any model needs to execute something at the time of the instance using db
            $this->construct();
        }
    }
}

?>