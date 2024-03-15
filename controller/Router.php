<?php

include_once(CONTROLLER.'Home.php');

class Router {

    private $request;
    private $routes = [
        "home.php" => ["controller" => "Home", "method" => "showHome"],
    ];

    public function __construct($request){
        $this->request = $request;
    }

    public function renderController(){
        $request = $this->request;

        if(isset($request, $this->routes)){
            $controllerName = $this->routes[$request]['controller'];
            $methodName = $this->routes[$request]['method'];
            
            $currentController = new $controllerName();
            $currentController->$methodName(); // Utilisation de la variable contenant le nom de la méthode
        }
        else{
            echo '404';
        } 
    }
}
