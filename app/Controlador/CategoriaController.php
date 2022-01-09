<?php

class CategoriaController extends Controller
{

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct()
    {
        $this->model = $this->model("Categoria");
    }
    
    function display($page = 1)
    {
        $params = array(
            'page' => intval(filter_var($page, FILTER_VALIDATE_INT))
        );
        $data = $this->model->getCategoria($params);

        $data['display'] = true;

        $this->view("CategoriaView", $data); // Se invoca a la Vista
    }

    function register()
    {
    }
}
