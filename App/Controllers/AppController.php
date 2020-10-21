<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{


    public function timeline(){
        if(!(isset($_SESSION['id'])) || !(isset($_SESSION['name']))){
            header('Location: /?login=erro');
        }
        $this->render('timeline');
    }


}

?>