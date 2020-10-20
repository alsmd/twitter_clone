<?php 

    namespace MF\Controller;

    abstract class Action{
        protected $view;


        public function __construct(){
            $this->view = new \stdClass(); //criaremos um obj vazio, para que seus atributo sejam construidos ao longo do processamento da nossa aplicação
        }

        protected function render($page,$layout){
            $this->view->page = $page;

            if(file_exists("../App/Views/".$layout.".phtml")){
                //renderiza nosso layout, que por sua vez ira renderizar a pagina solicitada
                require_once "../App/Views/".$layout.".phtml";
            }else{
                $this->content();
            }
            
        }

        protected function content(){
            //recupera o primeiro nome da class atual
            $classAtual = get_class($this);
            $classAtual = str_replace("App\\Controllers\\",'',$classAtual);
            $classAtual = strtolower(str_replace("Controller","",$classAtual));
    
            require_once "../App/Views/$classAtual /".$this->view->page.".phtml";
        }
        
    }

?>