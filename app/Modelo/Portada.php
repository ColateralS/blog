<?php
/*
 * Clase que contendra los metodos o funciones para acceder a la base de datos
 * y traer la informacion necesaria para ser presentada
*/
class Portada {
    function getPortada() {
        // Se instancia la clase que contiene las funciones para interactuar con la Base de Datos (db)
        #$db = new PDODB();
        $db = new MySQLDB();
        $data = array();
        $data['portada'] = array();

        try {
            $sql = "SELECT n.id, n.titulo, n.detalle, n.fechaPublicacion,  embebido AS imagen ";
            $sql .= ",c.nombre as catNoticia ";
            $sql .= "FROM noticia n, categoria c ";
            $sql .= "WHERE n.estado = 'PB' ";
            $sql .= "AND c.id = n.idCategoria ";
            $sql .= "AND c.estado = 'VIG' ";
            $sql .= "ORDER BY n.fechaPublicacion ";

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Portada/getPortada", $sql);
            }
            $datadb = $db->getData($sql);
            $data['portada'] = $datadb;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Portada/getNoticia", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
