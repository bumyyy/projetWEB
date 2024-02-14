<?php
require_once("./requete.php");

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case "authentification":
                isMdp($url[1], $url[2]); // Assurez-vous que la fonction s'appelle bien `getMdp` dans votre fichier `requete.php`
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