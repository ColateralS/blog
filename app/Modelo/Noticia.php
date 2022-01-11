<?php
/*
 * Clase que contendra los metodos o funciones para acceder a la base de datos
 * y traer la informacion necesaria para ser presentada o almacenar informacion
*/
class Noticia
{

    function __construct()
    {
    }

    /*
     * Funcion para poder obtener la informacion almacenada correspondiente a una noticia
    */
    function getNoticia($params)
    {
        //$db = new PDODB();
        $db = new MySQLDB();
        $data = array();

        $paramsDB = array();

        try {
            /*
             * Creo la sentencia SQL a ejecutar para obtener informacion de la noticia y sus categorias
            */
            $sql = "SELECT n.id AS idNoticia, n.idCategoria AS idCat, n.titulo, n.detalle, ";
            $sql .= "n.embebido, n.fechaPublicacion, ";
            $sql .= "c.nombre AS nombCat, c.descripcion AS descCat ";
            $sql .= "FROM noticia n, categoria c ";
            $sql .= "WHERE n.estado = 'PB' AND ";
            $sql .= "c.id = n.idCategoria AND ";
            $sql .= "c.estado = 'VIG' ";

            // Verifico el numero de registros afectados por una sentencia SQL
            $data['num_elems'] = $db->numRows($sql);

            // Se establec una cantidad de registros a ser retornados en la sentencia de consulta
            $sql .= "LIMIT ?, ?";

            // Se envian los parametros de la cantidad de registros a presentar en la consulta
            $paramsDB = array(
                'ii',
                ($params['page'] - 1) * NUM_ITEMS_PAG,
                NUM_ITEMS_PAG
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Noticia/getNoticia", $sql);
                writeLog(INFO_LOG, "Noticia/getNoticia", json_encode($paramsDB));
            }

            // Invoco la ejecucion de la sentencia con los parametros necesarios
            //$data['noticias'] = $db->getDataPrepared($sql, $paramsDB);
            $data['noticias'] = $db->getDataSinglePrepared($sql, $paramsDB);

            // Paginacion
            $data["pag"] = $params['page'];
            $data['last_page'] = ceil($data['num_elems'] / NUM_ITEMS_PAG);
            $data['success'] = true;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Noticia/getNoticia", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function getNoticiaPorID($idNot)
    {
        $db = new PDODB();

        try {
            $sql = "SELECT * FROM noticia WHERE id = $idNot";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/getNoticiaPorID", $sql);
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

    /*
     * Funcion para poder crear una nueva noticia
     * Recibe como parametros los datos ingresados en el correspondiente formulario de ingreso, tales como:
     *      'categoriaNoticia', 'tituloNoticia', 'detalleNoticia', 'embebido', 'fechaPublicacion', 'estadoNoticia'
    */
    function crearNoticia($params)
    {
        $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            /*
             * Se invoca a la funcion para obtener la siguinete secuencia de una noticia a registrar
             * en el aplicativo.
             * Se envian como parametros: La columna unica y secuencial
             *                            Nombre de la estructura que contiene la columna unica secuencial
            */
            $id_noticia = $db->getLastId("id", "noticia");

            /*
             * Se crea la sentencia para ingresar el registro del usuario en la tabla principal, en este caso "persona"
             * Las columnas para almacenar en la estructura son: 
             *      id, tipoNuc, nuc, primerNombre, segundoNombre, primerApellido, segundoApellido
            */
            $sql = "";
            $sql = "INSERT INTO noticia VALUES(?,?,?,?,?,?,?)";

            // Se crea un arreglo con los datos ingresados, listos para ser almancenados en la estructura principal "persona"
            $paramsDB = array(
                $id_noticia,  // Identificador unico secuencial de la estructura
                $params['categoriaNoticia'],
                $params['tituloNoticia'],
                $params['detalleNoticia'],
                $params['embebido'],
                $params['fechaPublicacion'],
                $params['estadoNoticia'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Noticia/crearNoticia", $sql);
                writeLog(INFO_LOG, "Noticia/crearNoticia", json_encode($paramsDB));
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
            writeLog(ERROR_LOG, "Noticia/crearNoticia", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function eliminarNoticia($id)
    {
        $noticeID = $id;
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            $sql = "DELETE FROM noticia WHERE id = $noticeID";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Noticia/elimiarNoticia", $sql);
                writeLog(INFO_LOG, "Noticia/eliminarNoticia", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['success'] = $success;
            $data['text-center'] = true;

            if ($success) {
                $data['message'] = "Se eliminó la noticia exitosamente. Pulsa <a href='/blog'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "Su eliminación no se ha realizado con éxito. Contacte con el Administrador";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Noticia/eliminarNoticia", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function editarNoticia($params)
    {
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;

        $paramsDB = array();

        try {
            $sql = "UPDATE noticia SET titulo = ?, detalle = ? WHERE id = ?";

            $paramsDB = array(
                $params['titulo'],
                $params['detalle'],
                $params['id'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Noticia/editarNoticia", $sql);
                writeLog(INFO_LOG, "Noticia/editarNoticia", json_encode($paramsDB));
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
            writeLog(ERROR_LOG, "Noticia/editarNoticia", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
