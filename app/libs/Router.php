<?php
    class Router{
        private $routes;

        /*
         * Function que permite registrar la ruta del modelo, controlador y metodo
         * que se desea ejecutar
        */
        public function registrarEnrutador(Route $route)  {
            $this->routes[] = $route;
        }

        /*
         * Function que resuelve la solicitud enviada
        */
        public function resolverSolicitud(string $request)  {

            $matches = [];
            foreach ($this->routes as $route) {
                if (preg_match($route->path, $request, $matches)) {

                    array_shift($matches);

                    require_once("../app/Controlador/" . $route->controller . ".php");

                    $params = $matches;
            
                    $controller = new $route->controller;

                    call_user_func_array([$controller, $route->method], $params);

                    return;
                }
            }
            throw new RuntimeException("La solicitud '$request' no es acorde a ningun enrutador.");
        }
    }


























































?>