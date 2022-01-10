<?php
require_once("../app/index.php");

/*
     * Registrar y devolver las extensiones de ficheros predeterminadas para spl_autoload
     * Esta función puede modificar y verificar las extensiones de ficheros que estará usando spl_autoload() 
    */
spl_autoload_extensions('.php');

/*
     * Registrar las funciones dadas como implementación de __autoload()
    */
spl_autoload_register();

$router = new Router();

/*
     * Se procede a registrar las rutas de los Controladores y los metodos a ser ejecutados
     * cuando se lo llama de alguna otra pagina
    */
$router->registrarEnrutador(new Route('/^\/blog\/Portada\/(\w[\-\w]*)$/', 'PortadaController', 'display'));

// Login
$router->registrarEnrutador(new Route('/^\/blog\/login-form/', 'LoginController', 'display'));
$router->registrarEnrutador(new Route('/^\/blog\/login/', 'LoginController', 'login'));
$router->registrarEnrutador(new Route('/^\/blog\/login-Admin/', 'AdminPortadaController', 'display'));
#$router->registrarEnrutador(new Route('/^\/blog\/remember/', 'LoginController', 'remember'));
#$router->registrarEnrutador(new Route('/^\/blog\/remember-form/', 'LoginController', 'display_remember'));

// Registro de Usuarios
$router->registrarEnrutador(new Route('/^\/blog\/register-form/', 'UsuarioController', 'display'));
$router->registrarEnrutador(new Route('/^\/blog\/register/', 'UsuarioController', 'register'));
$router->registrarEnrutador(new Route('/^\/blog\/users/', 'UsuarioController', 'displayUsers'));
$router->registrarEnrutador(new Route('/^\/blog\/eliminar-usuario\/(\w+)$/', 'UsuarioController', 'eliminarUsuario'));

// Categorias
$router->registrarEnrutador(new Route('/^\/blog\/category-form/', 'CategoriaController', 'display'));
$router->registrarEnrutador(new Route('/^\/blog\/crear-categoria-form/', 'CategoriaController', 'displayCrearCategoria'));
$router->registrarEnrutador(new Route('/^\/blog\/crear-categoria/', 'CategoriaController', 'crearCategoria'));
$router->registrarEnrutador(new Route('/^\/blog\/category-register/', 'CategoriaController', 'register'));
$router->registrarEnrutador(new Route('/^\/blog\/eliminar-categoria\/(\w+)$/', 'CategoriaController', 'eliminarCategoria'));

$router->registrarEnrutador(new Route('/^\/blog\/editar-categoria-form/', 'CategoriaController', 'displayEditarCategoria'));
$router->registrarEnrutador(new Route('/^\/blog\/editar-categoria/', 'CategoriaController', 'editarCategoria'));

// Noticias
$router->registrarEnrutador(new Route('/^\/blog\/notice-form/', 'NoticiaController', 'display'));
$router->registrarEnrutador(new Route('/^\/blog\/crear-noticia-form/', 'NoticiaController', 'displayCrearNoticia'));
$router->registrarEnrutador(new Route('/^\/blog\/crear-noticia/', 'NoticiaController', 'crearNoticia'));
$router->registrarEnrutador(new Route('/^\/blog\/eliminar-noticia\/(\w+)$/', 'NoticiaController', 'eliminarNoticia'));

// Desglos de una Noticia
$router->registrarEnrutador(new Route('/^\/blog\/detailNotice-form\/(\w+)$/', 'DesgloseNoticiaController', 'detail'));
$router->registrarEnrutador(new Route('/^\/blog\/detailCreate-notice-form\/(\w[\-\w]*)(\/\w+)?$/', 'DesgloseNoticiaController', 'displayCreateDetailNotice'));
//$router->registrarEnrutador(new Route('/^\/blog\/detailCreate-notice\/(\w[\-\w]*)(\/\w+)?$/', 'DesgloseNoticiaController', 'createDetailNotice'));
$router->registrarEnrutador(new Route('/^\/blog\/detailCreate-notice\/(\w+)$/', 'DesgloseNoticiaController', 'createDetailNotice'));

$router->registrarEnrutador(new Route('/^\/blog/', 'PortadaController', 'display'));
$router->resolverSolicitud($_SERVER['REQUEST_URI']);
