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
    function checkErrors($params) {
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

        if (empty($params['pNombre'])|| empty($params['sNombre'])) {
            array_push($errors, "Debe especificar un nombre al menos.");
        }

        if (empty($params['pApellido'])|| empty($params['sApellido'])) {
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
    function checkPass($params, &$errors) {
        if ($params['pass'] !== $params['confirm-pass']) {
            array_push($errors, "Las contraseña no coinciden.");
        }
    }
/*
    function get_all_info_user($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            $sql = "SELECT * ";
            $sql .= "FROM users ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/get_all_info_user", $sql);
                writeLog(INFO_LOG, "User/get_all_info_user", json_encode($paramsDB));
            }

            $data['info_user'] = $db->getDataSinglePrepared($sql, $paramsDB);
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/get_all_info_user", $e->getMessage());
        }

        $db->close();

        return $data;
    }
*/
    /*
     * Funcion que permite registrar un usuario en el aplicativo
     * Parametro de Entrada: Los datos ingresados en el formulario de ingreso
    */
    function registry($params) {
        $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            /*
             * Se invoca a la funcion para obtener la siguinete secuencia del usuario a registrar
             * en el aplicativo.
             * Se envian como parametros: La columna unica y secuencial
             *                            Nombre de la estructura que contiene la columna unica secuencial
            */
            $id_user = $db->getLastId("id", "persona");

            /*
             * Se crea la sentencia para ingresar el registro del usuario en la tabla principal, en este caso "persona"
             * Las columnas para almacenar en la estructura son: 
             *      id, tipoNuc, nuc, primerNombre, segundoNombre, primerApellido, segundoApellido
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
/*
    function edit_profile($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;

        $paramsDB = array();

        try {

            $sql = "UPDATE users ";
            $sql .= "SET name = ?, ";
            $sql .= "surname = ?, ";
            $sql .= "nickname = ?, ";
            $sql .= "email = ?, ";
            $sql .= "avatar = ? ";
            $sql .= "WHERE id = ? ";

            if (!empty($params['avatar'])) {
                $avatar = $params['avatar'];
            } else {
                $avatar = DEFAULT_AVATAR;
            }

            $paramsDB = array(
                $params['name'],
                $params['surname'],
                $params['nickname'],
                $params['email'],
                $avatar,
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/edit_profile", $sql);
                writeLog(INFO_LOG, "User/edit_profile", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['text-center'] = true;
            if ($data['success']) {
                $data['message'] = "La edición se ha completado con éxito. Pulsa <a href='/foro-ddr/'>aquí</a> para volver al inicio.";

                $data['user'] = array(
                    'id' => $params['id_user'],
                    'nickname' => $params['nickname'],
                    'rol' => $params['rol']
                );
                prepareDataLogin($data['user']);
            } else {
                $data['message'] = "La edición no se ha realizado con éxito. Contacte con discoduroderoer desde este <a href='https://www.discoduroderoer.es/contactanos/'>formulario</a>.";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/registry", $e->getMessage());
        }

        $db->close();

        return $data;
    }

    function change_password($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            if (isset($params['user_key'])) {

                // comprobar que el user key existe en la bd

                $sql = "UPDATE users ";
                $sql .= "SET pass = ? ";
                $sql .= "WHERE id = (SELECT id_user ";
                $sql .= "            FROM users_remember ";
                $sql .= "            WHERE user_key = ?)";

                $paramsDB = array(
                    hash_hmac("sha512", $params['pass'], HASH_PASS_KEY),
                    $params['user_key']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "User/change_password", $sql);
                    writeLog(INFO_LOG, "User/change_password", json_encode($paramsDB));
                }

                $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

                $sql = "DELETE FROM users_remember ";
                $sql .= "WHERE user_key = ? ";

                $paramsDB = array(
                    $params['user_key']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "User/change_password", $sql);
                    writeLog(INFO_LOG, "User/change_password", json_encode($paramsDB));
                }

                $db->executeInstructionPrepared($sql, $paramsDB);
            } else {

                $sql = "UPDATE users ";
                $sql .= "SET pass = ? ";
                $sql .= "WHERE id = ? ";

                $paramsDB = array(
                    hash_hmac("sha512", $params['pass'], HASH_PASS_KEY),
                    $params['id_user']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "User/change_password", $sql);
                    writeLog(INFO_LOG, "User/change_password", json_encode($paramsDB));
                }

                $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);
            }

            $data['text-center'] = true;
            if ($data['success']) {
                $data['message'] = "La contraseña ha sido cambiada";
            } else {
                $data['message'] = "Su contraseña no ha sido cambiada";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/change_password", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function unsubscribe($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            $sql = "UPDATE users SET ";
            $sql .= " borrado = 1 ";
            $sql .= " WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/unsubscribe", $sql);
                writeLog(INFO_LOG, "User/unsubscribe", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/unsubscribe", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function verification($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "SELECT ua.id_user, u.email, u.nickname, u.rol ";
            $sql .= "FROM users_activation ua, users u ";
            $sql .= "WHERE u.id = ua.id_user and ";
            $sql .= "ua.user_key = ? ";

            $paramsDB = array(
                $params['key']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/verification", $sql);
                writeLog(INFO_LOG, "User/verification", json_encode($paramsDB));
            }

            $nRows = $db->numRowsPrepared($sql, $paramsDB);

            if ($nRows === 1) {

                $dataUser = $db->getDataSinglePrepared($sql, $paramsDB);
                $id = $dataUser['id_user'];
                $email = $dataUser['email'];
                $nickname = $dataUser['nickname'];

                $sql = "UPDATE users SET ";
                $sql .= "verificado = 1 ";
                $sql .= "WHERE id = ? ";

                $paramsDB = array(
                    $id
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "User/verification", $sql);
                    writeLog(INFO_LOG, "User/verification", json_encode($paramsDB));
                }

                $db->executeInstructionPrepared($sql, $paramsDB);

                $sql = "DELETE FROM users_activation ";
                $sql .= "WHERE id_user = ? ";

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "User/verification", $sql);
                    writeLog(INFO_LOG, "User/verification", json_encode($paramsDB));
                }

                $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

                $data['text-center'] = true;
                if ($data['success']) {

                    $data['message'] = "¡Has sido verificado! ¡Bienvenido a Foro DDR!";

                    sendEmail($email, "¡Bienvenido al Foro DDR!", TEMPLATE_NEW_ACCOUNT_SUCCESS);

                    $data['user'] = array(
                        'id' => $id,
                        'nickname' => $nickname,
                        'rol' => IS_USER
                    );
                    prepareDataLogin($data['user']);
                } else {
                    $data['message'] = "Clave incorrecta.";
                }
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/verification", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function resend_confirmation($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "SELECT ua.id_user, ua.user_key ";
            $sql .= "FROM users_activation ua, users u ";
            $sql .= "WHERE ua.id_user = u.id ";
            $sql .= "AND u.email = ? ";
            $sql .= "AND u.verificado = ? ";

            $paramsDB = array(
                $params['email'],
                FALSE
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/resend_confirmation", $sql);
                writeLog(INFO_LOG, "User/resend_confirmation", json_encode($paramsDB));
            }

            $nRows = $db->numRowsPrepared($sql, $paramsDB);

            if ($nRows === 1) {
                $dataUserActivation = $db->getDataSinglePrepared($sql, $paramsDB);
                $data['success'] = true;
                $data['message'] = "Se ha reenviado el correo de activación";
                $paramsEmail = array(
                    'key' => $dataUserActivation['user_key']
                );

                sendEmail($params['email'], "Validación cuenta Foro DDR", TEMPLATE_NEW_ACCOUNT_NEED_VERIFICATION, $paramsEmail);
            } else {
                $data['success'] = false;
                $data['message'] = "No existe el correo o ya estas verificado";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/verification", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function search_topics_user($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            $sql = "SELECT mp.id_topic, t.title, ";
            $sql .= "DATE_FORMAT(MAX(m.date_creation), '%d/%m/%Y %T') as date_last_message, ";
            $sql .= "COUNT(*) as num_post ";
            $sql .= "FROM messages m, messages_public mp, topics t ";
            $sql .= "WHERE m.id = mp.id_message ";
            $sql .= "AND t.id = mp.id_topic ";
            $sql .= "AND m.user_origin = ? ";
            $sql .= "GROUP BY mp.id_topic, t.title ";
            $sql .= "ORDER BY date_last_message DESC";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "User/search_topics_user", $sql);
                writeLog(INFO_LOG, "User/search_topics_user", json_encode($paramsDB));
            }

            $data['topics_user'] = $db->getDataPrepared($sql, $paramsDB);

            $data['has_results'] = $db->numRowsPrepared($sql, $paramsDB) > 0;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "User/verification", $e->getMessage());
        }

        $db->close();
        return $data;
    }*/
}