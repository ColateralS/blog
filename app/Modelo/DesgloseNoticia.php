<?php

class DesgloseNoticia {

    function __construct() {
    }

    /*
     * Funcion que permite obtener el Desglose de toda una noticia en particular
    */
    function getDesgloseNoticia($params) {
        $db = new MySQLDB();
        $data = array();

        $paramsDB = array();

        try {
            /*
             * Creo la sentencia SQL a ejecutar para obtener informacion de la noticia y el desglose de la misma
            */
            $sql = "SELECT n.titulo, n.detalle, n.fechaPublicacion,  embebido AS imagen ";
            $sql .= ",d.desglose, d.embebidoDesglose AS imgDesglose ";
            $sql .= "FROM noticia n, noticiadesglose d ";
            $sql .= "WHERE n.id = ? ";
            $sql .= "AND n.estado = 'PB' ";
            $sql .= "AND d.idNoticia = n.id ";
            $sql .= "AND d.estado = 'PB' ";
            $sql .= "ORDER BY d.idDesglose ";

            $paramsDB = array('i',
                strtolower($params['idNoticia']),
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Noticia/getNoticia", $sql);
                writeLog(INFO_LOG, "Noticia/getNoticia", json_encode($paramsDB));
            }

            // Invoco la ejecucion de la sentencia con los parametros necesarios
            $data['desgloseNoticia'] = $db->getDataSinglePrepared($sql, $paramsDB);
            $data['success'] = true;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "DesgloseNoticia/getDesgloseNoticia", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    /*
     * Funcion para poder crear un desglose de una noticia
     * Recibe como parametros los datos ingresados en el correspondiente formulario de ingreso, tales como:
     *      'categoriaNoticia', 'tituloNoticia', 'detalleNoticia', 'embebido', 'fechaPublicacion', 'estadoNoticia'
    */
    function crearDesgloseNoticia($params) {
        $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            /*
             * Se invoca a la funcion para obtener la siguinete secuencia de un desglose correspondiente a una noticia a registrar
             * en el aplicativo.
             * Se envian como parametros: La columna unica y secuencial
             *                            Nombre de la estructura que contiene la columna unica secuencial
            */
            $id_noticiadesglose = $db->getLastId("idDesglose", "noticiadesglose");

            /*
             * Se crea la sentencia para ingresar el registro del usuario en la tabla principal, en este caso "persona"
             * Las columnas para almacenar en la estructura son: 
             *      id, tipoNuc, nuc, primerNombre, segundoNombre, primerApellido, segundoApellido
            */
            $sql = "";
            $sql = "INSERT INTO noticiadesglose VALUES(?,?,?,?,?)";
            // Se crea un arreglo con los datos ingresados, listos para ser almancenados en la estructura principal "desglose de la noticia"
            $paramsDB = array(
                $id_noticiadesglose,  // Identificador unico secuencial de la estructura
                $params['idNoticia'],
                $params['desglose'],
                $params['embebido'],
                $params['estado']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "DesgloseNoticia/crearDesgloseNoticia", $sql);
                writeLog(INFO_LOG, "DesgloseNoticia/crearDesgloseNoticia", json_encode($paramsDB));
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
            writeLog(ERROR_LOG, "DesgloseNoticia/crearDesgloseNoticia", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }   

}