<?php

class UsuarioController extends Controller {

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct()
    {
        $this->model = $this->model("Usuario");
    }

    /*
     * Funcion para poder presentar la forma para el ingreso de los datos de un usuario que se vaya a registrar
     * en el aplicativo y pueda loguearse en otra ocasion
    */
    function display() {
         /*
         * Se activa la bandera para indicarle a la vista que debe presentar las opciones para 
         * ingresar los campos de registro de un usuario
        */
        $data['registry'] = true; 
        $this->view("UsuarioView", $data); // Se invoca a la Vista
    }
/*
    function display_profile()
    {

        isLogged();

        $data = array();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->get_all_info_user($params);

        $data['profile'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UsuarioController/display_profile", json_encode($data));
        }

        $this->view("UserView", $data);
    }

    function display_edit_profile()
    {

        isLogged();

        $data = array();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->get_all_info_user($params);

        $data['edit_profile'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UsuarioController/display_edit_profile", json_encode($data));
        }

        $this->view("UserView", $data);
    }

    function edit_profile()
    {

        isLogged();

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            $params = array(
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'nickname' => $_POST['nickname'],
                'email' => $_POST['email'],
                'id_user' => filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT)
            );

            $errors = $this->model->checkErrors($params);

            if (count($errors) === 0) {

                $params = array(
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'id_user' => $_POST['id_user'],
                    'name' => $_POST['name'],
                    'rol' => $_POST['rol'],
                    'surname' => $_POST['surname'],
                    'avatar' => $_POST['avatar']
                );

                $data = $this->model->edit_profile($params);
            } else {

                $data['info_user'] = array(
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'rol' => $_POST['rol'],
                    'id' => filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT),
                    'avatar' => $_POST['avatar']
                );

                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['edit_profile'] = true;
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UsuarioController/edit_profile", json_encode($data));
            }

            $this->view("UserView", $data);
        }
    }

    function edit_password($userKey = null)
    {

        if (!isset($userKey)) {
            isLogged();
        }

        $data = array(
            'user_key' => $userKey
        );

        $data['change_password'] = true;

        $this->view("UserView", $data);
    }*/

    /*
     * Funcion que me permite registrar un usuario en el aplicativo
    */
    function register() {
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
    function change_password()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            $params = array(
                'pass' => $_POST['pass'],
                'confirm-pass' => $_POST['confirm-pass']
            );

            if (!isset($params['user_key'])) {
                isLogged();
            }

            $errors = array();

            $this->model->checkPass($params, $errors);

            // Si no hay errores, muestro el mensaje
            if (count($errors) === 0) {

                $session = new Session();

                if (isset($_POST['user_key'])) {
                    $params = array(
                        'pass' => $_POST['pass'],
                        'user_key' => $_POST['user_key']
                    );
                } else {
                    $params = array(
                        'id_user' => $session->getAttribute(SESSION_ID_USER),
                        'pass' => $_POST['pass']
                    );
                }

                $data = $this->model->change_password($params);
            } else {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['change_password'] = true;
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UsuarioController/change_password", json_encode($data));
            }

            $this->view("UserView", $data);
        }
    }

    function logout()
    {
        $session = new Session();
        $session->destroySession();
        redirect_to_url(BASE_URL);
    }

    function display_unsubscribe()
    {
        $data = array();
        $data['display_unsubscribe'] = true;
        $this->view("UserView", $data);
    }

    function unsubscribe()
    {

        isLogged();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->unsubscribe($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UsuarioController/unsubscribe", json_encode($data));
        }

        if ($data['success']) {
            $session->destroySession();
            redirect_to_url(BASE_URL);
        }
    }

    function verification($key)
    {

        $params = [
            'key' => $key
        ];

        $data = $this->model->verification($params);

        $this->view("UserView", $data);
    }

    public function display_verification()
    {
        $data = array();
        $data['form_verification'] = true;
        $this->view("UserView", $data);
    }

    public function resend_confirmation()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $params = array(
                'email' => $_POST['email']
            );

            $data = $this->model->resend_confirmation($params);

            $this->view("UserView", $data);
        }
    }

    function no_unsubscribe()
    {
        header("Location: /foro-ddr/profile");
    }

    function display_topics_user()
    {

        isLogged();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->search_topics_user($params);

        $data['display_topics_user'] = true;

        $this->view("UserView", $data);
    }*/
}