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

    /*
     * Función para presentar los datos de la categoría obtenidos desde la BD.
    */
    function display($page = 1)
    {
        $params = array(
            'page' => intval(filter_var($page, FILTER_VALIDATE_INT))
        );

        // Almacena en $data la información retornada por la función getCategoria del Modelo.
        $data = $this->model->getCategoria($params);

        $data['display'] = true;

        $this->view("CategoriaView", $data); // Se invoca a la Vista
    }

    /*
     * Función para presentar el formulario que permite realizar la creación de los datos de la categoría.
    */
    function displayCrearCategoria()
    {
        $data = array();
        $data['create'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/displayCrearCategoria", json_encode($data));
        }

        $this->view("CategoriaView", $data); // Se invoca a la Vista
    }

    /*
     * Función para crear la categoría. Esta función controla que se envien datos por el usuario.
    */
    function crearCategoria()
    {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            // Se guarda los valores enviados por el usuario.
            $params = array(
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'estado' => 'VIG'
            );


            // Almacena en $data la información retornada por la función crearCategoria del Modelo.
            $data = $this->model->crearCategoria($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "CategoriaController/crearCategoria", json_encode($data));
            }

            if (!$data['success']) {
                $data['display'] = true;
            }

            $this->view("CategoriaView", $data); // Se invoca a la Vista
        }
    }

    /*
    // Función para eliminar la categoría seleccionada por el usuario basandose en su ID.
    */
    function eliminarCategoria($params)
    {
        $data = array();

        // Almacena en $data la información retornada por la función eliminarCategoria del Modelo.
        $data = $this->model->eliminarCategoria($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/eliminarCategoria", json_encode($data));
        }

        if (!$data['success']) {
            $data['display'] = true;
        }

        $this->view("CategoriaView", $data); // Se invoca a la Vista
    }

    /*
     * Función para presentar el formulario que permite realizar la edición de los datos de la categoría.
    */
    function displayEditarCategoria($params)
    {
        $data = array();
        $data['update'] = true;

        $data['params'] = $params;

        // Almacena en $data la información retornada por la función getCategoriaPorID del Modelo.
        $dataCat = $this->model->getCategoriaPorID($params);

        $data['categorias'] = $dataCat;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/displayEditarCategoria", json_encode($data));
        }

        $this->view("CategoriaView", $data); // Se invoca a la Vista
    }

    /*
     * Función para editar la categoría. Esta función controla que categoría editar en base al ID seleccionado.
    */
    function editarCategoria($params)
    {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $data = array();

            // Se guarda los valores enviados por el usuario.
            $params = array(
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'id' => $params,
            );

            // Almacena en $data la información retornada por la función editarCategoria del Modelo.
            $data = $this->model->editarCategoria($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "CategoriaController/editarCategoria", json_encode($data));
            }

            $this->view("CategoriaView", $data); // Se invoca a la Vista
        }
    }
}
