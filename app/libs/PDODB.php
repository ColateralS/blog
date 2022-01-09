<?php
    /*
     * Clase que contiene los metodos o funciones necesarias para ejecutar las senrencias a la Base de Datos
    */
    class PDODB {

        private $host = "localhost";
        private $usuario = "root";
        private $pass = "";
        private $db = "bd_periodico";

        private $connection;

        function __construct() {

            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            $this->connection = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db,
                $this->usuario,
                $this->pass,
                $opciones
            );
        }

        function getData($sql) {
            $data = array();
            $result = $this->connection->query($sql);
            $error = $this->connection->errorInfo();
            if ($error[0] === "00000") {
                $result->execute();
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        array_push($data, $row);
                    }
                }
            } else {
                throw new Exception($error[2]);
            }
            return $data;
        }

        /*
         * Funcion que permite preparar una sentencia a ser ejecutada con los parametros necesarios
         * para la ejecucion de la misma.
         * Recibe como parametros:
         *      $sql - Sentencia SQL a preparar para la ejecucion
         *      $params - Parametros necesarios para la ejecucion de la sentencia SQL
        */
        function getDataPrepared($sql, $params) {
            $data = array(); // Declara un arreglo para retornar la informacion a ser consultada
            $result = $this->connection->prepare($sql); // Prepara la sentencia SQL
            $error = $this->connection->errorInfo(); // Verifica si existe error o no en la ejecucion de la sentencia
            if ($error[0] === "00000") {
                // De no existir error alguno, se procede a ejecutar la sentencia
                $result->execute($params);
                // Se verifica que existan registros a ser devueltos en la consulta
                if ($result->rowCount() > 0) {
                    // Por cada registro devuelto por la sentencia ejecutada, se procede a crear un arreglo con
                    // dicha informacion para ser devuelta
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        array_push($data, $row);
                    }
                }
            } else {
                throw new Exception($error[2]);
            }
            return $data;
        }

        /*
         * Funcion que permite determinar el numero de filas afectadas por una sentencia SQL
         * Recibe como parametro:
         *      $sql - Sentencia SQL a ejecutar
        */
        function numRows($sql) {
            $result = $this->connection->query($sql);
            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute();
                return $result->rowCount();
            } else {
                throw new Exception($error[2]);
            }
        }

        function numRowsPrepared($sql, $params)
        {
            $result = $this->connection->prepare($sql);
            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute($params);
                return $result->rowCount();
            } else {
                throw new Exception($error[2]);
            }
        }

        function getDataSingle($sql)
        {

            $result = $this->connection->query($sql);

            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute();
                if ($result->rowCount() > 0) {
                    return $result->fetch(PDO::FETCH_ASSOC);
                }
            } else {
                throw new Exception($error[2]);
            }
            return null;
        }


        function getDataSingleProp($sql, $prop)
        {

            $result = $this->connection->query($sql);
            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute();
                if ($result->rowCount() > 0) {
                    $data = $result->fetch(PDO::FETCH_ASSOC);
                    return $data[$prop];
                }
            } else {
                throw new Exception($error[2]);
            }
            return null;
        }

        function getDataSinglePrepared($sql, $params)
        {

            $result = $this->connection->prepare($sql);

            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute($params);
                if ($result->rowCount() > 0) {
                    return $result->fetch(PDO::FETCH_ASSOC);
                }
            } else {
                throw new Exception($error[2]);
            }
            return null;
        }


        function getDataSinglePropPrepared($sql, $prop, $params)
        {

            $result = $this->connection->prepare($sql);
            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute($params);
                if ($result->rowCount() > 0) {
                    $data = $result->fetch(PDO::FETCH_ASSOC);
                    return $data[$prop];
                }
            } else {
                throw new Exception($error[2]);
            }
            return null;
        }

        function executeInstruction($sql)
        {

            $result = $this->connection->query($sql);
            $error = $this->connection->errorInfo();

            if ($error[0] === "00000") {
                $result->execute();
                return $result->rowCount() > 0;
            } else {
                throw new Exception($error[2]);
            }
        }

        /*
         * Funcion para ejecutar una sentencia previamente preparada.
         * Recibe como parametros:
         *      La sentencia a ejecutar, por ejemplo un INSERT
         *      Parametros a ser reemplzados en la sentencia al momento de ejecutarla
        */
        function executeInstructionPrepared($sql, $params) {
            $result = $this->connection->prepare($sql);  // Se prepara la sentencia a ejecutar
            $error = $this->connection->errorInfo(); // Se verifica si existen errores
            if ($error[0] === "00000") {
                // De no haber errores, se procede a enlazar los parametros con la sentencia
                $result->execute($params);

                // Se retorna la catidad de registros afectados
                return $result->rowCount() > 0;
            } else {
                // Se retorna el error generado, de ser el caso
                throw new Exception($error[2]);
            }
        }

        function close()
        {
            $this->connection = null;
        }

        /*
         * Funcion que permite obtener el ultimo identificador unico de una estructura en el caso
         * de ser secuencial
         * Parametros de entrada: Columna secuencial unica de la estructura 
         *                        Nombre de la tabla que contiene la columna unica secuencial  
        */
        function getLastId($field, $table)
        {
            $sql = "SELECT IFNULL((MAX(" . $field . ") + 1), 1) as id FROM " . $table;
            return $this->getDataSingleProp($sql, "id");
        }
    }