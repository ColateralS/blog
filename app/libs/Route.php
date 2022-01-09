<?php
    /*
     * Clase que permite construir informacion de la ruta del Modelo, el nombre del controlador y que metodo
     * se debe de ejecutar
    */
    class Route    {
        public $path;
        public $controller;
        public $method;

        /*
         * Definicion del constructor de la clase que va a recibir la ruta del Modelo, 
         * el controlador que maneja y el metodo a implementar
         * se debe de ejecutar
        */
        public function __construct(string $path, string $controller, string $method) {
            $this->path = $path;
            $this->controller = $controller;
            $this->method = $method;
        }
    }

?>