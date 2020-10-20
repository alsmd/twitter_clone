<?php

namespace MF\init;

abstract class Bootstrap{
    //nossa relação de rotas disponiveis
    private $routes;

    //
    abstract protected function initRoutes();

    //a verificação do path sera feita automaticamente na hora da instancia do nosso objeto
    public function __construct(){
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    //recupera e setando as possiveis rotas
    public function getRoutes(){
        return $this->routes;
    }

    public function setRoutes(array $routes){
        $this->routes = $routes;
    }


    protected function run($url){
        foreach($this->getRoutes() as $key => $route){

        //se a rota solicitada esta presente em nossa relação de rotas
            if($url == $route['route']){
                //iremos instanciar dinamicamente um objeto controller correspondete ao path valido solicidado
                $class = "App\\Controllers\\".ucfirst($route["controller"]);

                $controller = new $class;

                $action = $route['action'];
                //e executar sua respectiva ação

                $controller->$action();
            }
        }
    }
    
    
    //pega o path acessado pelo usuario
    protected function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

}

?>