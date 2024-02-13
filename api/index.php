<?php
require_once("./requete.php");

try {
if(!empty($_GET['demande'])){
    $url = explode('/',filter_var($_GET['demande'], FILTER_SANITIZE_URL));
    switch($url[0]){
        case "authentification" : 
            getMdp($url[1]);
            break;
        }

    
        break;
        default :
            throw new Exception ("La demande n'est pas valide");
            break;
    }
}
else{
    throw new Exception ("Probleme de recuperation de données, mauvaise url 222");
}


catch(Exception $e){
    $erreur =[
        "message" => $e->getMessage(),
        "code" => $e->getCode()];
    print_r($erreur);
}