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

    function displayCrearCategoria()
    {
        $data = array();
        $data['create'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/displayCrearCategoria", json_encode($data));
        }

        $this->view("CategoriaView", $data);
    }

    function crearCategoria()
    {
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();
            $params = array(
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'estado' => 'VIG'
            );

            $data = $this->model->crearCategoria($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "CategoriaController/crearCategoria", json_encode($data));
            }

            if (!$data['success']) {
                $data['display'] = true;
            }

            $this->view("CategoriaView", $data);
        }
    }

    function eliminarCategoria($params)
    {
        $data = array();

        $data = $this->model->eliminarCategoria($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/eliminarCategoria", json_encode($data));
        }

        if (!$data['success']) {
            $data['display'] = true;
        }

        $this->view("CategoriaView", $data);
    }

    function displayEditarCategoria($params)
    {
        $data = array();
        $data['update'] = true;

        $data['params'] = $params;

        $dataCat = $this->model->getCategoriaPorID($params);

        $data['categorias'] = $dataCat;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "CategoriaController/displayEditarCategoria", json_encode($data));
        }

        $this->view("CategoriaView", $data);
    }

    function editarCategoria($params)
    {
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $data = array();

            $params = array(
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'id' => $params,
            );

            $data = $this->model->editarCategoria($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "CategoriaController/editarCategoria", json_encode($data));
            }

            $this->view("CategoriaView", $data);
        }
    }
}
