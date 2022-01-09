<?php

class DesgloseNoticiaController extends Controller {

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct() {
        $this->model = $this->model("DesgloseNoticia");
    }

    /*
     * Funcion para poder presentar la forma del Desglose de una noticia selecciondad
    */
    function detail($idNoticia) { 
        $params = array(
            'idNoticia' => $idNoticia
        ); 
        $data = $this->model->getDesgloseNoticia($params);
        /*
         * Se activa la bandera para indicarle a la vista que debe presentar el desglose de una noticia
        */
        $data['detail'] = true;

        $this->view("DesgloseNoticiaView", $data); // Se invoca a la Vista
    }

    /*
     * Funcion para poder presentar la forma que me permitira ingresar informacion de los desgloses de una noticia
    */
    function displayCreateDetailNotice($params) {
        $data = array();
        $data['create'] = true;

        $data['params'] = $params;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "DesgloseNoticiaController/displayCreateDetailNotice", json_encode($data));
        }

        $this->view("DesgloseNoticiaView", $data);
    }

    function createDetailNotice($params) {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */    
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $data = array();
            $imgContenido = null;

            if(isset($_POST["submit"]) && isset($_FILES['file'])) {
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
            }
        
            $params = array(
                'idNoticia' => $params,
                'desglose' => $_POST['desglose'],
                'embebido' => $imgContenido,
                'estado' => 'PB',
            );
            // Array ( [idNoticia] => 3 [desglose] => sdfsdfsf [embebido] => ) parametrosDB: 1
           $data = $this->model->crearDesgloseNoticia($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "NoticiaController/crearNoticia", json_encode($data));
            }

            if (!$data['success']) {
                $data['display'] = true;
            }

            $this->view("DesgloseNoticiaView", $data);
        }
    }
}   