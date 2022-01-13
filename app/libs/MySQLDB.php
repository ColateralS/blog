<?php

class MySQLDB
{

    private $host = "localhost";
    private $usuario = "root";
    private $pass = "";
    private $db = "bd_periodico";

    private $connection;

    function __construct()
    {

        $this->connection = mysqli_connect(
            $this->host,
            $this->usuario,
            $this->pass,
            $this->db
        );

        $this->connection->set_charset("utf8");

        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_error());
        }
    }

    /*
     * Funcion que me permite obtener un recordset en funcion a la instruccion SELECT proporcionado
    */
    function getData($sql) { 
        $data = array();
        $result = mysqli_query($this->connection, $sql);
        $error = mysqli_error($this->connection);

        if (empty($error)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($data, $row);
                }
            }
        } else {
            throw new Exception($error);
        }
        return $data;
    }

    function numRows($sql)
    {
        $result = mysqli_query($this->connection, $sql);
        $error = mysqli_error($this->connection);

        if (empty($error)) {
            return mysqli_num_rows($result);
        } else {
            throw new Exception($error);
        }
    }

    function getDataSingle($sql) {

        $result = mysqli_query($this->connection, $sql);

        $error = mysqli_error($this->connection);

        if (empty($error)) {
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        } else {
            throw new Exception($error);
        }
        return null;
    }

    /*
     * Funcion para poder ejecutar una sentencia previamente preparada
     * Recibe como parametros:
     *      La sentencia a ejecutar
     *      Los parametros necesarios a ser reemplazados en la sentencia preparada previamente
    */
    function getDataSinglePrepared($sql, $params) {
        // Crea el prepared statement
        $sth = mysqli_stmt_init($this->connection);
        // Prepara el prepared statement
        $sth = mysqli_prepare($this->connection, $sql);    
        if (!($sth)) {
            $error = mysqli_error($this->connection);
            throw new Exception($error);
        }
        //now we need to add references
        $tmp = array();
        foreach($params as $key => $value){ 
            $tmp[$key] = &$params[$key];
        }
        // now us the new array
        call_user_func_array(array($sth, 'bind_param'), $tmp);
        $sth->execute();

        /* Fetch result to array */
        $res = $sth->get_result();
        $a_data = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $a_data[]=$row;
        }
        #print_r($a_data);
        $sth->close();
        return $a_data;
    }

    /*function getDataSingleProp($sql, $prop) {
        $result = mysqli_query($this->connection, $sql);
        $error = mysqli_error($this->connection);
        if (empty($error)) {
            if (mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                return $data[$prop];
            }
        } else {
            throw new Exception($error);
        }
        return null;
    }

    function executeInstruction($sql)
    {
        $success = mysqli_query($this->connection, $sql);

        $error = mysqli_error($this->connection);

        if (empty($error)) {
            return $success;
        } else {
            throw new Exception($error);
        }
    }*/

    function close()
    {
        mysqli_close($this->connection);
    }

    /*
     * Funcion que permite obtener el ultimo identificador unico de una estructura en el caso
     * de ser secuencial 
    */
    function getLastId() {
        return mysqli_insert_id($this->connection);
    }
}