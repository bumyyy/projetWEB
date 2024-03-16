<?php

include_once(CONTROLLER.'Home.php');

class Router {

    private $request;
    private $routes = [
        "home.php" => ["controller" => "Home", "method" => "showHome"],
        "" => ["controller" => "Home", "method" => "showHome"], // A voir si on enlève
    ];

    public function __construct($request) {
        $this->request = $request;
    }

    public function renderController() {
        $request = $this->request;

        if(isset($this->routes[$request])){         // (isset($request, $this->routes))         c'était ça avant
            $controllerName = $this->routes[$request]['controller'];
            $methodName = $this->routes[$request]['method'];
            
            $currentController = new $controllerName();
            $currentController->$methodName(); // Utilisation de la variable contenant le nom de la méthode
        }
        else {
            echo '404';
        } 
    }
}


// http://stagetier.fr/?r=home.php      ça marche dans l'url, on arrive sur page d'accueil home.php
// http://stagetier.fr                  j'essaie d'arriver sur la même page car j'sais pas s'il faut faire ça ._.