<?php
    #define("PAGE_URL", "http://localhost/blog/public/");
    define("PAGE_URL", "http://localhost/blog");

    //APPROOT
    define('APPROOT', dirname(dirname(__FILE__)));

    //Sitename
    define('SITENAME', 'Blog de Noticias');
    
    define("BASE_URL", "/blog/");

    define("PATH_LOG", "../app/log/");
    define("FILE_LOG", "log.txt");

    define("NUM_ITEMS_PAG", 10);

    // Definicion de la clave secreta compartida que se usará para generar el mensaje cifrado de la variante HMAC. 
    define("HASH_PASS_KEY", "noticias");

    define("SESSION_ID_USER", "id");
    define("SESSION_IS_ADMIN", "isAdmin");

    #define("TRUE", "1");
    #define("FALSE", "0");

    define("IS_ADMIN", "1");
    define("IS_USER", "2");

    /*define("ALL_CATEGORIES", "1");
    define("ONLY_PARENTS", "2");
    define("ONLY_CHILDS", "3");*/

    define("ERROR_GENERAL", "Ha ocurrido un error, contacte con el administrador");
    define("MODE_DEBUG", "1");
    define("ERROR_LOG", "E");
    define("INFO_LOG", "I");

    define("DEFAULT_AVATAR", "default-avatar.jpg");

    define("LENGTH_USER_KEY", 20);
    define("USER_KEY_NUMBER", 0);
    define("USER_KEY_MAYUS", 1);
    define("USER_KEY_MINUS", 2);
?>