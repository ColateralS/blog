<?php

class Usuario
{

    function __construct()
    {
    }

    /*
     * Funcion que permite verificar si la informacion ingresada para crear un usuario
     * esta completa para que no existan errores al momento de grabarla en la Base de Datos
     * Se recibe como parametro, la informacion del usuario a crear
    */
    function checkErrors($params)
    {
        $db = new PDODB(); // Se instancia la clase de la Base de Datos

        $errors = array();
        $paramsDB = array();

        // Se verifican cada uno de los campos ingresados antes de crear un usuario
        if (empty($params['tipoNuc'])) {
            array_push($errors, "Debe especificar un tipo de documento.");
        }
        if (empty($params['nuc'])) {
            array_push($errors, "Debe especificar un numero de documento.");
        }

        if (empty($params['pNombre']) || empty($params['sNombre'])) {
            array_push($errors, "Debe especificar un nombre al menos.");
        }

        if (empty($params['pApellido']) || empty($params['sApellido'])) {
            array_push($errors, "Debe especificar un apellido al menos.");
        }

        if (empty($params['nickname'])) {
            array_push($errors, "El campo alias no puede estar vacio.");
        }

        if (empty($params['email'])) {
            array_push($errors, "El email no puede estar vacio.");
        }

        if (!isset($params['id_user'])) {
            if (empty($params['pass'])) {
                array_push($errors, "El pass no puede estar vacio.");
            } else {
                // Verifico la clave con su confirmacion que sean las mismas
                $this->checkPass($params, $errors);
            }
        }

        /*
         * Genero la sentencia para determinar si el alias o nickname del usuario ingresado
         * ya existe
        */
        $sql = "SELECT count(*) as num_suscriptor ";
        $sql .= "FROM suscriptor ";
        $sql .= "WHERE trim(lower(nombreCorto)) = ? ";
        if (isset($params['id_user'])) {
            $sql .= "and idPersona <> ? ";
            $paramsDB = array(
                trim(strtolower($params['nickname'])),
                $params['id_user']
            );
        } else {
            $paramsDB = array(
                trim(strtolower($params['nickname']))
            );
        }

        if (isModeDebug()) {
            writeLog(INFO_LOG, "Usuario/checkErrors", $sql);
            writeLog(INFO_LOG, "Usuario/checkErrors", json_encode($paramsDB));
        }

        // Se ejecuta la sentencia para verificar si trae registros con las condiciones dadas (alias o nickname existente)
        $num_suscriptor = $db->getDataSinglePropPrepared($sql, "num_suscriptor", $paramsDB);

        if ($num_suscriptor > 0) {
            // Si se encontro informacion con los datos del alias o nickname
            array_push($errors, "El nombre corto ya existe.");
        }

        /*
         * Genero la sentencia para determinar si el correo del usuario ingresado
         * ya existe
        */
        $sql = "SELECT count(*) as num_suscriptor ";
        $sql .= "FROM suscriptor ";
        $sql .= "WHERE trim(lower(correo)) = ? ";
        if (isset($params['id_user'])) {
            $sql .= "and idPersona <> ? ";
            $paramsDB = array(
                trim(strtolower($params['nickname'])),
                $params['id_user']
            );
        } else {
            $paramsDB = array(
                trim(strtolower($params['nickname']))
            );
        }

        if (isModeDebug()) {
            writeLog(INFO_LOG, "Usuario/checkErrors", $sql);
            writeLog(INFO_LOG, "Usuario/checkErrors", json_encode($paramsDB));
        }

        // Se ejecuta la sentencia para verificar si trae registros con las condiciones dadas (mail existente)
        $num_suscriptor = $db->getDataSinglePropPrepared($sql, "num_suscriptor", $paramsDB);

        if ($num_suscriptor > 0) {
            // Mail ingresado ya existe con otro usuario
            array_push($errors, "El email ya existe.");
        }

        $db->close();
        return $errors; // Retorno un arreglo con todos los posibles errores encontrados
    }

    /*
     * Funcion que permite verificar si la clave y la confirmacion de la misma es correcta
    */
    function checkPass($params, &$errors)
    {
        if ($params['pass'] !== $params['confirm-pass']) {
            array_push($errors, "Las contraseña no coinciden.");
        }
    }

    function getUsuarios($params)
    {
        $db = new MySQLDB();
        $data = array();
        $data['usuarios'] = array();

        try {
            $sql = "SELECT * FROM persona";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Usuario/getUsuarios", $sql);
            }
            $datadb = $db->getData($sql);
            $data['usuarios'] = $datadb;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Usuario/getUsuarios", $e->getMessage());
        }

        $db->close();

        return $data;
    }

    function getUsuarioPorID($idUser)
    {
        $db = new PDODB();

        try {
            $sql = "SELECT * FROM persona WHERE id = $idUser";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/getUsuarioPorID", $sql);
            }
            $data = $db->getData($sql);
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
        }

        $db->close();
        return $data;
    }

    //Función que permite registrar un usuario en el aplicativo.
    //Parametro de Entrada: Los datos ingresados en el formulario de ingreso
    function registry($params)
    {
        $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            /*
             * Se invoca a la funcion para obtener la siguinete secuencia del usuario a registrar
             * en el aplicativo.
             * Se envian como parametros: La columna unica y secuencial
             * Nombre de la estructura que contiene la columna unica secuencial
            */
            $id_user = $db->getLastId("id", "persona");

            /*
             * Se crea la sentencia para ingresar el registro del usuario en la tabla principal, en este caso "persona"
             * Las columnas para almacenar en la estructura son: 
             * id, tipoNuc, nuc, primerNombre, segundoNombre, primerApellido, segundoApellido
            */
            $sql = "";
            $sql = "INSERT INTO persona VALUES(?,?,?,?,?,?,?)";

            // Se crea un arreglo con los datos ingresados, listos para ser almancenados en la estructura principal "persona"
            $paramsDB = array(
                $id_user,  // Identificador unico secuencial de la estructura
                $params['tipoNuc'],
                $params['nuc'],
                $params['pNombre'],
                $params['sNombre'],
                $params['pApellido'],
                $params['sApellido'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Usuario/registry", $sql);
                writeLog(INFO_LOG, "Usuario/registry", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            /*
             * Se crea la sentencia para ingresar el registro del usuario en la tabla de suscriptores
             * Las columnas para almacenar en la estructura son: 
             *      idPersona, nombreCorto o NickName, correo, clave, estado
            */
            $sql = "";
            $sql = "INSERT INTO suscriptor VALUES(?,?,?,?,?)";

            // Se crea un arreglo con los datos ingresados, listos para ser almancenados en la estructura principal "suscriptor"
            $paramsDB = array(
                $id_user,  // Identificador unico secuencial de la estructura
                $params['nickname'],
                $params['email'],
                /*
                 * Genera un valor cifrado mediante una clave especificada usando el método HMAC
                 *    "sha512" - Nombre del algoritmo para cifrar (es decir "md5", "sha256", "haval160,4", etc..).
                 *    "$params['pass']" - Mensaje para cifrar.  
                 *    "noticias" - Clave secreta compartida que se usará para generar el mensaje cifrado de la variante HMAC.   
                */
                hash_hmac("sha512", $params['pass'], "noticias"),
                'A'
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Usuario/registry", $sql);
                writeLog(INFO_LOG, "Usuario/registry", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['success'] = $success;
            $data['text-center'] = true;

            if ($success) {
                $data['message'] = "Su registro se ha completado con éxito. Pulsa <a href='/blog/'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "Su registro no se ha realizado con éxito. Contacte con el Administrador";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Usuario/registry", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function eliminarUsuario($id)
    {
        $userID = $id;
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            $sql = "DELETE FROM persona WHERE id = $userID";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Usuario/eliminarUsuario", $sql);
                writeLog(INFO_LOG, "Usuario/eliminarUsuario", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['success'] = $success;
            $data['text-center'] = true;

            if ($success) {
                $data['message'] = "Se eliminó el usuario exitosamente. Pulsa <a href='/blog'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "Su eliminación no se ha realizado con éxito. Contacte con el Administrador";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Usuario/eliminarUsuario", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function editarUsuario($params)
    {
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;

        $paramsDB = array();

        try {

            $sql = "UPDATE persona SET nuc = ?, primerNombre = ?, segundoNombre = ?, primerApellido = ?, segundoApellido = ? WHERE id = ?";

            $paramsDB = array(
                $params['nuc'],
                $params['primerNombre'],
                $params['segundoNombre'],
                $params['primerApellido'],
                $params['segundoApellido'],
                $params['id'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Usuario/editarUsuario", $sql);
                writeLog(INFO_LOG, "Usuario/editarUsuario", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['text-center'] = true;
            if ($data['success']) {
                $data['message'] = "La edición se ha completado con éxito. Pulsa <a href='/blog'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "La edición no se ha realizado con éxito.";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Usuario/editarUsuario", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
