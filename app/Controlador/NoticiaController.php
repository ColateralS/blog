<?php

class NoticiaController extends Controller {

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct() {
        $this->model = $this->model("Noticia");
    }

    /*
     * Funcion para poder presentar la forma para el ingreso de los datos de un usuario que se vaya a registrar
     * en el aplicativo y pueda loguearse en otra ocasion
    */
    function display($page = 1) {
        $params = array(
            'page' => intval(filter_var($page, FILTER_VALIDATE_INT))
        ); 
        $data = $this->model->getNoticia($params);
        /*
         * Se activa la bandera para indicarle a la vista que debe presentar las opciones para 
         * ingresar los campos de registro de un usuario
        */
        $data['display'] = true;

        $this->view("NoticiaView", $data); // Se invoca a la Vista
    }

    /*
     * Funcion que permite activar la seña que presentara el formulario para ingreso de los datos de una noticia
    */
    function displayCrearNoticia() {
        $data = array();
        $data['create'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "NoticiaController/displayCrearNoticia", json_encode($data));
        }

        $this->view("NoticiaView", $data);
    }

    function crearNoticia() {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */  
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            // Array ( [cbxCategoria] => 1 [titulo] => asd [detalle] => asda [fechaNoticia] => s [cbxEstado] => PB [action] => ) 
            // Array ( [imagen] => Array ( [name] => 41En1DxSEFL.jpg [type] => image/jpeg [tmp_name] => C:\xampp\tmp\phpF75.tmp [error] => 0 [size] => 9341 ) )

            // Se verifica el tamaño de la imagen y la información relacionada.
            $revisar = getimagesize($_FILES["imagen"]["tmp_name"]);

            if($revisar !== false) {
                $image = $_FILES['imagen']["tmp_name"];
                /*
                 * addslashes - Devuelve una cadena con barras invertidas delante de los caracteres predefinidos. 
                 *      No toma ningún carácter especificado en el parámetro.
                 * file_get_contents - Lee un archivo en una cadena. La función utiliza técnicas de mapeo de memoria que son compatibles con el servidor 
                 *      y, por lo tanto, mejoran el rendimiento, lo que la convierte en una forma preferida de leer el contenido de un archivo.
                */
                $imgContenido = addslashes(file_get_contents($image));
            }

            $date = new DateTime($_POST['fechaPublicacion']);
            $params = array(
                'categoriaNoticia' => $_POST['cbxCategoria'],
                'tituloNoticia' => $_POST['titulo'],
                'detalleNoticia' => $_POST['detalle'],
                'embebido' => $imgContenido,
                'fechaPublicacion' => $date->format('Y-m-d'),
                'estadoNoticia' => trim($_POST['cbxEstado'])
            );

            $data = $this->model->crearNoticia($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "NoticiaController/crearNoticia", json_encode($data));
            }

            if (!$data['success']) {
                $data['display'] = true;
            }

            $this->view("NoticiaView", $data);
        }
    }
}   