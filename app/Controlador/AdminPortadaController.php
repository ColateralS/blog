<?php

class AdminPortadaController extends Controller
{

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct()
    {
        $this->model = $this->model("AdminPortada");
    }

    /*
     * Función para presentar el formulario para el ingreso de los datos de un usuario que se vaya a registrar
     * en el aplicativo y pueda loguearse en otra ocasión
    */
    function display()
    {
        /*
         * Se activa la bandera para indicarle a la vista que debe presentar las opciones para 
         * ingresar los campos de registro de un usuario
        */
        $data['display'] = true;
        $this->view("AdminPortadaView", $data); // Se invoca a la Vista
    }
}
