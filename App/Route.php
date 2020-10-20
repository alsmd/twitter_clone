<?php 

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {
    //Qual o controller e a sua respectiva ação que sera tomada para cada path
    protected function initRoutes(){

        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        $routes['inscreverse']= array(
            'route' => '/inscreverse',
            'controller' => 'IndexController',
            'action' => 'inscreverse'
        );
        parent::setRoutes($routes);
    }
}

?>