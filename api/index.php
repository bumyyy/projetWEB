<?php
require_once("./requete.php");

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        
        switch ($url[0]) {
            case "authentification":
                isMdp(urldecode($url[1]), $url[2]); // urldecode pour transformer le %40 en @
                break;
            
            case "combox":
                if (!isset($url[1])) {
                    throw new Exception("La demande pour 'combox' n'est pas spécifiée.");
                }
                switch ($url[1]) {
                    case "secteur":
                        getSecteur();
                        break;
                    case "ville":
                        getVille();
                        break;
                    default:
                        throw new Exception("La demande pour 'combox' n'est pas valide.");
                }
                break;
            case "entreprise":
                if (!isset($url[1])) {
                    throw new Exception("La demande pour 'entreprise' n'est pas spécifiée.");
                }
                switch ($url[1]) {
                    case "secteur":
                        getEntrepriseBySecteur($url[2]);
                        break;
                    case "ville":
                        getEntrepriseByVille($url[2]);
                        break;
                    case "note":
                        getEntrepriseByNote($url[2], $url[3]);
                        break;
                    default:
                        throw new Exception("La demande pour 'entreprise' n'est pas valide.");
                }
                break;

            default:
                throw new Exception("La demande n'est pas valide");
        }
    } else {
        throw new Exception("Problème de récupération de données, mauvaise URL");
    }
} catch (Exception $e) {
    // Assurez-vous d'envoyer une réponse HTTP appropriée en cas d'erreur.
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => $e->getMessage()]);
}
catch (Exception $e) {
    $erreur = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($erreur);
}