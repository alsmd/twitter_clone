<?php 

    namespace MF\Controller;

    abstract class Action{
        protected $view;


        public function __construct(){
            $this->view = new \stdClass(); // an empty obj
            session_start();
        }

        protected function render($page,$layout = 'layout'){
            $this->view->page = $page;

            if(file_exists("../App/Views/".$layout.".phtml")){
                //render the layout that render the content
                require_once "../App/Views/".$layout.".phtml";
            }else{
                $this->content();
            }
            
        }

        protected function content(){
            //get the Class's name
            $classAtual = get_class($this);
            $classAtual = str_replace("App\\Controllers\\",'',$classAtual);
            $classAtual = strtolower(str_replace("Controller","",$classAtual));
    
            require_once "../App/Views/$classAtual/".$this->view->page.".phtml";
        }
        
    }

?>