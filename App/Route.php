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

        $routes['register']= array(
            'route' => '/register',
            'controller' => 'IndexController',
            'action' => 'register'
        );
        $routes['timeline']= array(
            'route' => '/timeline',
            'controller' => 'AppController',
            'action' => 'timeline'
        );
        $routes['authenticate']= array(
            'route' => '/authenticate',
            'controller' => 'AuthController',
            'action' => 'authenticate'
        );
        $routes['logoff']= array(
            'route' => '/logoff',
            'controller' => 'AuthController',
            'action' => 'logoff'
        );
        parent::setRoutes($routes);
    }
}

?>