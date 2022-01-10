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

            $sql = "UPDATE categoria SET nombre = ?, descripcion = ? WHERE id = 1";

            $paramsDB = array(
                $params['nombre'],
                $params['descripcion'],
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


    /*
     * Funcion para poder crear una nueva noticia
     * Recibe como parametros los datos ingresados en el correspondiente formulario de ingreso, tales como:
     *      'categoriaNoticia', 'tituloNoticia', 'detalleNoticia', 'embebido', 'fechaPublicacion', 'estadoNoticia'
    */
    // function crearNoticia($params) {
    //     $db = new PDODB(); // Se instancia la clase de la conexion a la Base de Datos
    //     $data = array();
    //     $data['show_message_info'] = true;
    //     $paramsDB = array();

    //     try {
    //         /*
    //          * Se invoca a la funcion para obtener la siguinete secuencia de una noticia a registrar
    //          * en el aplicativo.
    //          * Se envian como parametros: La columna unica y secuencial
    //          *                            Nombre de la estructura que contiene la columna unica secuencial
    //         */
    //         $id_noticia = $db->getLastId("id", "noticia");

    //         /*
    //          * Se crea la sentencia para ingresar el registro del usuario en la tabla principal, en este caso "persona"
    //          * Las columnas para almacenar en la estructura son: 
    //          *      id, tipoNuc, nuc, primerNombre, segundoNombre, primerApellido, segundoApellido
    //         */
    //         $sql = "";
    //         $sql = "INSERT INTO noticia VALUES(?,?,?,?,?,?,?)";

    //         // Se crea un arreglo con los datos ingresados, listos para ser almancenados en la estructura principal "persona"
    //         $paramsDB = array(
    //             $id_noticia,  // Identificador unico secuencial de la estructura
    //             $params['categoriaNoticia'],
    //             $params['tituloNoticia'],
    //             $params['detalleNoticia'],
    //             $params['embebido'],
    //             $params['fechaPublicacion'],
    //             $params['estadoNoticia'],
    //         );

    //         if (isModeDebug()) {
    //             writeLog(INFO_LOG, "Noticia/crearNoticia", $sql);
    //             writeLog(INFO_LOG, "Noticia/crearNoticia", json_encode($paramsDB));
    //         }

    //         // Se invoca a la ejecucion de la sentencia
    //         $success = $db->executeInstructionPrepared($sql, $paramsDB);

    //         $data['success'] = $success;
    //         $data['text-center'] = true;

    //         if ($success) {
    //             $data['message'] = "Su registro se ha completado con éxito. Pulsa <a href='/blog/'>aquí</a> para volver al inicio.";
    //         } else {
    //             $data['message'] = "Su registro no se ha realizado con éxito. Contacte con el Administrador";
    //         }
    //     } catch (Exception $e) {
    //         $data['success'] = false;
    //         $data['message'] = ERROR_GENERAL;
    //         writeLog(ERROR_LOG, "Noticia/crearNoticia", $e->getMessage());
    //     }

    //     $db->close();
    //     return $data; // Se retorna la informacion generada al momento de crear el usuario
    // }   
