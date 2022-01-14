<?php

class MySQLDB
{

    private $host = "localhost"; //Declara el Host.
    private $usuario = "root"; //Declara el nombre de usuario.
    private $pass = ""; //Declara la contraseña en este caso vacia ya que no posee.
    private $db = "bd_periodico"; //Declara el nombre de la Base de Datos.

    private $connection; //Declara la conexión.

    //Constructor de la clase que permite ejecutar la conexión.
    function __construct()
    {

        //Crea la conexión a la base de datos utilizando la libreria mysqli
        //En este caso envia todos los datos almacenados en las variables creadas anteriormente.
        $this->connection = mysqli_connect(
            $this->host,
            $this->usuario,
            $this->pass,
            $this->db
        );

        //Define el conjunto de caracteres como UTF8
        $this->connection->set_charset("utf8");

        //Sentencia para comprobar si existen errores durante la conexión.
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_error());
        }
    }

    //Función que me permite obtener un recordset en funcion a la instruccion SELECT proporcionado
    function getData($sql) { 
        $data = array(); //Crea un arreglo llamado $data
        $result = mysqli_query($this->connection, $sql); //Almacena el resultado de una query a la base de datos en la variable $result
        $error = mysqli_error($this->connection); //Almacena un error de la base de datos.

        //Sentencia para corroborar si llega un error.
        //Si no hay error.
        if (empty($error)) {
            if (mysqli_num_rows($result) > 0) { //Valida si el número de filas obtenidas es mayor a 0.
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($data, $row); //Inserta la información en el arreglo.
                }
            }
        } else {
            throw new Exception($error); //Muestra una excepción.
        }
        return $data; //Retorna la Data.
    }

    //Función que retorna el numero de filas de una sentencia SQL.
    function numRows($sql)
    {
        //Almacena en $result la consulta generada a partir de la sentencia SQL.
        $result = mysqli_query($this->connection, $sql);
        //Almacena un error en caso de haberlo.
        $error = mysqli_error($this->connection);

        //Sentencia para corroborar si llega un error.
        //Si no hay error.
        if (empty($error)) {
            return mysqli_num_rows($result); //Ejecuta la instrucción.
        } else {
            throw new Exception($error); //Caso contrario muestra el error.
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
     * Función para poder ejecutar una sentencia previamente preparada
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
        //Añadimos las referencias
        $tmp = array();
        foreach($params as $key => $value){ 
            $tmp[$key] = &$params[$key];
        }
        //Creamos el nuevo array
        call_user_func_array(array($sth, 'bind_param'), $tmp);
        $sth->execute();

        //Asiganmos el valor obtenido al array creado anteriormente.
        $res = $sth->get_result();
        $a_data = [];
        while($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $a_data[]=$row;
        }

        $sth->close();
        return $a_data;
    }


    //Función para cerrar la conexión a la BD.
    function close()
    {
        mysqli_close($this->connection); //Cierra la conexión
    }

    /*
     * Funcion que permite obtener el ultimo identificador unico de una estructura en el caso
     * de ser secuencial 
    */
    function getLastId() {
        return mysqli_insert_id($this->connection);
    }
}