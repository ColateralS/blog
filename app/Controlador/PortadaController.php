<?php
class PortadaController extends Controller
{

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct()
    {
        $this->model = $this->model("Portada");
    }

    /*
     * Función para presentar los datos de la categoría obtenidos desde la BD.
    */
    function display($id_cat_parent = null)
    {
        // Almacena en $data la información retornada por la función getPortada del Modelo.
        $data = $this->model->getPortada();

        if (isModeDebug()) {
            writeLog(INFO_LOG, "PortadaController/display", json_encode($data));
        }

        $this->view("PortadaView", $data); // Invoca a la Vista
    }
}
