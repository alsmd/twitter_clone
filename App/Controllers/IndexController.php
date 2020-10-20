<?php

namespace App\Controllers;
//Models

//Recursos do miniframework
use MF\Controller\Action;

class IndexController extends Action{

    public function index(){
        $this->render('index','layout');
    }
    public function inscreverse(){


        $this->render('inscreverse','layout');
    }
    

}


?>