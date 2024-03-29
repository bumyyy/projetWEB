<?php

// constante du chemin vers notre projet
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('HOST', "//".$_SERVER['HTTP_HOST']);

require_once ROOT.'/app/Model.php';
require_once ROOT.'/app/Controller.php';

require_once ROOT.'/vendor/autoload.php';

//On sépare les parametres
$urlParams = explode('/', $_GET['p']);

//On regarde si le parametre existe
if($urlParams[0] != ''){
    $controller = ucfirst($urlParams[0]); //pour mettre la premiere lettr en maj pour apres appeller la classe
     
    if( count($urlParams)>1 && $urlParams[1] != ''){ //si l'action n'est pas specifiée dans l'url, on appelle l'index
        $action = $urlParams[1];
    }else{
        $action = 'index';
    }

    require_once(ROOT.'/controllers/'.$controller.'.php'); //on appelle la classe associée
    $controller = new $controller(); //ex : Accueil = new Accueil
    
    if(method_exists($controller, $action)){ // On verifie que la methode existe
        unset($urlParams[0]); //On enleve les 2 params qui ont deja été utlisés 
        unset($urlParams[1]);
        call_user_func_array([$controller, $action], $urlParams); //Appeler une class->method en y ajoutant des params
    }else{
        echo "la page n'existe pas 1";
    }
}else{
    echo "la page n'existe pas";
}
