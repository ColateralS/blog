<?php

class Login {
    function __construct() {
    }

    /*
     * Funcion que me permite validar si las campos del formulario Login no se encuentran vacios
     * ademas de verificar si las credenciales ingresadas son las correctas en funcion al usuario
     * que desea ingresar al aplicativo
    */
    function checkLogin($params)
    {

        $db = new MySQLDB();

        try {

            /*
             * Se verifica que las credenciales ingresadas no se encuentren vacias
            */
            if (empty($params['nick_email']) && empty($params['pass'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Usuario/email y contraseña requeridos";
            } elseif (empty($params['nick_email'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Usuario/email requerido";
            } elseif (empty($params['pass'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Contraseña requerida";
            } else {
                /*
                 * Procedo a buscar los datos ingresados (nickname, mail) en la estructura de un Suscriptor
                 * para verificar si el que esta intentando ingresar es una persona que tiene privilegios de
                 * suscriptor para leer todas las noticias. 
                */
                $data = array();
                $paramsDB = array();

                $sql = "SELECT s.* ";
                $sql .= "FROM suscriptor s ";
                $sql .= "WHERE (s.nombreCorto = ? OR s.correo = ?) ";
                $sql .= "AND s.clave = ? ";
                $sql .= "AND s.estado = 'A' ";

                $paramsDB = array('sss',
                    strtolower($params['nick_email']),
                    strtolower($params['nick_email']),
                    hash_hmac("sha512", strtolower($params['pass']), HASH_PASS_KEY)
                );
                #print hash_hmac("sha512", strtolower($params['pass']), HASH_PASS_KEY);

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "Login/checkLogin", $sql);
                    writeLog(INFO_LOG, "Login/checkLogin", json_encode($paramsDB));
                }

                $data = $db->getDataSinglePrepared($sql, $paramsDB);
                if (count($data) > 0) {
                    $data['success'] = true;
                    $datosDevueltos = array();
                    foreach($data as $posicion) {
                        // Verifico si los datos devueltos por la consulta es un arreglo u objeto
                        if (is_array($posicion) || is_object($posicion)) {
                            foreach($posicion as $clave => $valor) {
                                # Se crea un arreglo asociativo con los valores devueltos de la consulta
                                $datosDevueltos[$clave] = $valor;
                            }
                            // Indico que el usuario que se Logueo no es un administrador del sitio
                            $datosDevueltos["isAdmin"] = "0";
                        }
                    }
                    $data['usuario'] = $datosDevueltos;
                } else {
                    /*
                     * Procedo a buscar los datos ingresados (nickname, mail) en la estructura de un Administrador
                     * para verificar si el que esta intentando ingresar es una persona que tiene privilegios de
                     * administrador y poder dar mantenimiento al sitio de las noticias. 
                    */
                    $data = array();
                    $paramsDB = array();

                    $sql = "SELECT a.* ";
                    $sql .= "FROM administrador a ";
                    $sql .= "WHERE a.usuario = ? ";
                    $sql .= "AND a.clave = ? ";
                    $sql .= "AND a.estado = 'A' ";

                    $paramsDB = array('ss',
                        strtolower($params['nick_email']),
                        hash_hmac("sha512", strtolower($params['pass']), HASH_PASS_KEY)
                    );
                    #print hash_hmac("sha512", strtolower($params['pass']), HASH_PASS_KEY);

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "Login/checkLogin", $sql);
                        writeLog(INFO_LOG, "Login/checkLogin", json_encode($paramsDB));
                    }

                    $data = $db->getDataSinglePrepared($sql, $paramsDB);
                    if (count($data) > 0) {
                        $data['success'] = true;
                        //Array ( [0] => Array ( [idPersona] => 1 [usuario] => admin [clave] => admin [estado] => A ) [success] => 1 )
                        $datosDevueltos = array();
                        foreach($data as $posicion) {
                            // Verifico si los datos devueltos por la consulta es un arreglo u objeto
                            if (is_array($posicion) || is_object($posicion)) {
                                foreach($posicion as $clave => $valor) {
                                    # Se crea un arreglo asociativo con los valores devueltos de la consulta
                                    $datosDevueltos[$clave] = $valor;
                                }
                                // Indico que el usuario que se Logueo es un administrador del sitio
                                $datosDevueltos["isAdmin"] = "1";
                            }
                        }
                        $data['usuario'] = $datosDevueltos;
                    } else {
                        $data['show_message_info'] = true;
                        $data['success'] = false;
                        $data['message'] = "Usuario/email o contraseña incorrectos";
                    }
                }
            }
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Login/checkLogin", $e->getMessage());
        }

        $db->close();
        return $data;
    }
}