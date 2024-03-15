<?php

class Autoload {

    public static function start() {

        //spl_autoload_register(array(__CLASS__, 'load')); // Correction de la définition du callback

        $root = $_SERVER['DOCUMENT_ROOT']; // C:/www/projetWEB
        $host = $_SERVER['HTTP_HOST']; // stagetier.fr
        
        define('HOST', 'http://' . $host);
        define('ROOT', $root);
        
        define('CONTROLLER', ROOT . '/controller/');
        define('VIEW', ROOT . '/view/');
        define('MODEL', ROOT . '/model/');
        
        define('ASSETS', HOST . '/assets/');
    }

    public static function load($class) { // Modification de la signature de la méthode pour inclure le paramètre $class

        if (file_exists(MODEL . $class . '.php')) {
            require_once MODEL . $class . '.php';
        } elseif (file_exists(CONTROLLER . $class . '.php')) {
            require_once CONTROLLER . $class . '.php';
        }
    }
}


