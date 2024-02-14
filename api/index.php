<?php
require_once("./requete.php");

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case "authentification":
                isMdp(urldecode($url[1]), $url[2]); // urldecode pour transformer le %40 en @
                break;
            default:
                throw new Exception("La demande n'est pas valide");
        }
    } else {
        throw new Exception("Problème de récupération de données, mauvaise URL");
    }
} catch (Exception $e) {
    $erreur = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($erreur);
}