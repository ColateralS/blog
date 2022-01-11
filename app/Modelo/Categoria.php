<?php
/*
 * Clase que contendra los metodos o funciones para acceder a la base de datos
 * y traer la informacion necesaria para ser presentada o almacenar informacion
*/
class Categoria
{

    function __construct()
    {
    }

    /*
     * Funcion para poder obtener la informacion almacenada correspondiente a una categoria
    */
    function getCategoria($params)
    {
        $db = new MySQLDB();
        $data = array();
        $data['categorias'] = array();

        try {
            $sql = "SELECT * FROM categoria";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/getCategoria", $sql);
            }
            $datadb = $db->getData($sql);
            $data['categorias'] = $datadb;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Portada/getNoticia", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function getCategoriaPorID($idCat)
    {
        $db = new PDODB();

        try {
            $sql = "SELECT * FROM categoria WHERE id = $idCat";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/getCategoriaPorID", $sql);
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

    function crearCategoria($params)
    {
        $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            $id_categoria = $db->getLastId("id", "categoria");
            $sql = "";
            $sql = "INSERT INTO categoria VALUES(?,?,?,?)";
            $paramsDB = array(
                $id_categoria,  // Identificador unico secuencial de la estructura
                $params['nombre'],
                $params['descripcion'],
                $params['estado'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/crearCategoria", $sql);
                writeLog(INFO_LOG, "Categoria/crearCategoria", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['success'] = $success;
            $data['text-center'] = true;

            if ($success) {
                $data['message'] = "Su registro se ha completado con éxito. Pulsa <a href='/blog'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "Su registro no se ha realizado con éxito. Contacte con el Administrador";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Categoria/crearCategoria", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function eliminarCategoria($id)
    {
        $catedoryID = $id;
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            $sql = "DELETE FROM categoria WHERE id = $catedoryID";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/eliminarCategoria", $sql);
                writeLog(INFO_LOG, "Categoria/eliminarCategoria", json_encode($paramsDB));
            }

            // Se invoca a la ejecucion de la sentencia
            $success = $db->executeInstructionPrepared($sql, $paramsDB);

            $data['success'] = $success;
            $data['text-center'] = true;

            if ($success) {
                $data['message'] = "Se eliminó la categoría exitosamente. Pulsa <a href='/blog'>aquí</a> para volver al inicio.";
            } else {
                $data['message'] = "Su eliminación no se ha realizado con éxito. Contacte con el Administrador";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Categoria/eliminarCategoria", $e->getMessage());
        }

        $db->close();
        return $data; // Se retorna la informacion generada al momento de crear el usuario
    }

    function editarCategoria($params)
    {
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;

        $paramsDB = array();

        try {
            $sql = "UPDATE categoria SET nombre = ?, descripcion = ? WHERE id = ?";

            $paramsDB = array(
                $params['nombre'],
                $params['descripcion'],
                $params['id'],
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Categoria/editarCategoria", $sql);
                writeLog(INFO_LOG, "Categoria/editarCategoria", json_encode($paramsDB));
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
            writeLog(ERROR_LOG, "Categoria/editarCategoria", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
