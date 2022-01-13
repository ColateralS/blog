<?php

class UsuarioController extends Controller
{

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct()
    {
        $this->model = $this->model("Usuario");
    }

    /*
     * Función para poder presentar la forma para el ingreso de los datos de un usuario que se vaya a registrar
     * en el aplicativo y pueda loguearse en otra ocasion
    */
    function display()
    {
        /*
         * Se activa la bandera para indicarle a la vista que debe presentar las opciones para 
         * ingresar los campos de registro de un usuario
        */
        $data['registry'] = true;
        $this->view("UsuarioView", $data); // Se invoca a la Vista
    }

    /*
     * Función para presentar los datos de los usuarios obtenidos desde la BD.
    */
    function displayUsers($page = 1)
    {
        $params = array(
            'page' => intval(filter_var($page, FILTER_VALIDATE_INT))
        );
        $data = $this->model->getUsuarios($params);

        $data['displayUsers'] = true;

        $this->view("UsuarioView", $data); // Se invoca a la Vista
    }

    /*
    // Función para eliminar la categoría seleccionada por el usuario basandose en su ID.
    */
    function eliminarUsuario($params)
    {
        $data = array();

        // Almacena en $data la información retornada por la función eliminarUsuario del Modelo.
        $data = $this->model->eliminarUsuario($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UsuarioController/eliminarUsuario", json_encode($data));
        }

        if (!$data['success']) {
            $data['display'] = true;
        }

        $this->view("UsuarioView", $data); // Se invoca a la Vista
    }

    /*
     * Función que me permite registrar un usuario en el aplicativo
    */
    function register()
    {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();
            // Se crea un arreglo con la informacion del usuario a crear
            $params = array(
                'tipoNuc'  => $_POST['cbxtipoNuc'],
                'nuc'  => $_POST['nuc'],
                'pNombre' => $_POST['pNombre'],
                'sNombre' => $_POST['sNombre'],
                'pApellido' => $_POST['pApellido'],
                'sApellido' => $_POST['sApellido'],
                'nickname' => $_POST['nickname'],
                'email' => $_POST['email'],
                'pass' => $_POST['pass'],
                'confirm-pass' => $_POST['confirm-pass']
            );

            /*
             * Invoco a la funcion para que verifique los posibles errores a encontrar en la informacion ingresada
             * al momento de querer registrar un usuario.
             * Dentro de los posibles errores a encontrar tenemos:
             * Que no se haya especificado informacion para columnas de la Base de Datos, como: Primer NOmbre, etc
             * Que la clave no sea la misma que la verificacion de la misma.
             * Que los datos como alias o nickname como tambien el mail ingresado ya existan con otro usuario 
            */
            $errors = $this->model->checkErrors($params);

            // Verifico si se encontraron errores
            if (count($errors) === 0) {
                // 'avatar' => $_POST['avatar']
                $params = array(
                    'tipoNuc'  => $_POST['cbxtipoNuc'],
                    'nuc'  => $_POST['nuc'],
                    'pNombre' => $_POST['pNombre'],
                    'sNombre' => $_POST['sNombre'],
                    'pApellido' => $_POST['pApellido'],
                    'sApellido' => $_POST['sApellido'],
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'pass' => $_POST['pass'],
                    'confirm-pass' => $_POST['confirm-pass']
                );
                // Se invoca a la funcion para almacenar la informacion ingresada al momento de crear un usuario
                $data = $this->model->registry($params);
            } else {
                // Se encontraron errores, se procede a reportar o presentar por pantalla los mismos
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['registry'] = true;
                $data['pNombre'] = $_POST['pNombre'];
                $data['nickname'] = $_POST['nickname'];
                $data['email'] = $_POST['email'];
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UsuarioController/register", json_encode($data));
            }
            // Invoco a la vista
            $this->view("UsuarioView", $data);
        }
    }

    /*
     * Función para presentar el formulario que permite realizar la edición de los datos de el usuario.
    */
    function displayEditarUsuario($params)
    {
        $data = array();
        $data['update'] = true;

        $data['params'] = $params;

        // Almacena en $data la información retornada por la función getUsuarioPorID del Modelo.
        $dataUser = $this->model->getUsuarioPorID($params);

        $data['usuarios'] = $dataUser;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UsuarioController/displayEditarUsuario", json_encode($data));
        }

        $this->view("UsuarioView", $data); // Se invoca a la Vista
    }

    /*
     * Función para editar la categoría. Esta función controla que categoría editar en base al ID seleccionado.
    */
    function editarUsuario($params)
    {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $data = array();

            // Se guarda los valores enviados por el usuario.
            $params = array(
                'nuc' => $_POST['nuc'],
                'primerNombre' => $_POST['primerNombre'],
                'segundoNombre' => $_POST['segundoNombre'],
                'primerApellido' => $_POST['primerApellido'],
                'segundoApellido' => $_POST['segundoApellido'],
                'id' => $params,
            );

            // Almacena en $data la información retornada por la función editarUsuario del Modelo.
            $data = $this->model->editarUsuario($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UsuarioController/editarUsuario", json_encode($data));
            }

            $this->view("UsuarioView", $data); // Se invoca a la Vista
        }
    }
}
