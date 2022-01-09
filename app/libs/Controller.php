<?php

    class Controller{

        function __construct(){ }

        public function model($modelo){
            require_once("../app/Modelo/".$modelo.".php");
            return new $modelo();
        }
        
        public function view($view, $data=[]){            
            if(file_exists("../app/Vista/".$view.".php")){
                $session = new Session();
                $data['login']= $session->getAttribute('login');
                $data['nickname']=$session->getAttribute('nickname');
                $data['isAdmin']=$session->getAttribute('isAdmin');
                #if($data['login'] === TRUE){
                #    $data['msg_no_read']=msgNoRead();
                #}
                require_once("../app/Vista/".$view.".php");
            }else{
                die("No existe la vista");
            }
        }


    }

?>