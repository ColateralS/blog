<?php
class LoginController extends Controller {

    private $model;

    /*
     * Constructor de la clase que permite asociar con el Modelo
    */
    function __construct() {
        $this->model = $this->model("Login");
    }

    /*
     * Funcion para poder presentar la forma para el ingreso de las credenciales y poder
     * logearse en el aplicativo
    */
    function display() {
        $data = array();
        /*
         * Se activa la bandera para indicarle a la vista que debe presentar las opciones para 
         * ingresar las credenciales
        */
        $data['display_login'] = true;
        $this->view("LoginView", $data); // Se invoca a la Vista
    }

    /*
     * Funcion para ejecutar los procesos cuando el usuario que desea ingresar ha dado clic en el boton de Login
    */
    function login() {
        /*
         * Se verifica el contenido del array asociativo "$_POST" que no este vacio
         * y que el metodo usado sea el "POST"
        */  
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $data = array();
            // Se reciben las credenciales ingresadas en el formulario de Login
            $params = array(
                'nick_email' => $_POST['nick_email'],
                'pass' => $_POST['pass']
            );

            /*
             * Se procede a invocar a una funcion para que verifique la informacion ingresada
             * en los campos del formulario Login
            */
            $data = $this->model->checkLogin($params);
            if (isModeDebug()) {
                writeLog(INFO_LOG, "LoginController/login", json_encode($data));
            }
            
            /*
             * Si se ingreso informacion en los controles del formulario Login y 
             * la validacion de las credenciales fue exitosa, se procede a obtener
             * informacion del usuario que se Logueo para almacenar dicha informacion
             * en una sesion
            */
            if ($data['success']) {
                /*
                 * Se obtiene informacion del usuario que se Logueo en el aplicativo
                */
                if ($data['usuario']) {
                    // Invoco a la funcion para almacenar datos de la sesion del usuario
                    // que se loguea
                    prepareDataLogin($data['usuario']);
                }

                /*
                 * Se recorre los datos del usuario que se Logueo para verificar si es un administrador 
                 * o un usuario suscriptor, ya que el administrador va a poder ingresar a dar mantenimiento
                 * al sitio
                */
                $isAdmin = "0";
                foreach($data['usuario'] as $clave => $valor) {
                    // Si el usuario logueado es el Administardor del sitio
                    if (strtolower($clave) == 'isadmin') {
                        $isAdmin = "1";
                    }
                }
                if ($isAdmin == "1") {
                    $this->view("AdminPortadaView", $data);
                } else {
                    redirect_to_url(BASE_URL);
                }
            } else {
                $this->view("LoginView", $data);
            }
        }
    }

    function display_remember() {

        $data = array();

        $data['display_recover_password'] = true;

        $this->view("LoginView", $data);
    }

    function remember() {


        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {


            $data = array();

            $params = array(
                'email' => $_POST['email']
            );

            $data = $this->model->sendNotificationRememeber($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Login/remember", json_encode($data));
            }

            $this->view("LoginView", $data);
        }
    }
    
}
?>