<?php
    class PortadaController extends Controller {

        private $model;

        function __construct() {
            $this->model = $this->model("Portada");
        }

        function display($id_cat_parent = null) {
            $data = $this->model->getPortada();
            
            if(isModeDebug()){
                writeLog(INFO_LOG, "PortadaController/display", json_encode($data));
            }

            $this->view("PortadaView", $data);
        }
    }