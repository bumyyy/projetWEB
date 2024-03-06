<?php
require_once("./requete.php");

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        
        switch ($url[0]) {
            case "authentification":
                isMdp(urldecode($url[1]), $url[2]); // urldecode pour transformer le %40 en @
                
                break;
            case "utilisateur":
                getUtilisateur($url[1]);
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
                    getAllEntreprise();
                    break;
                }
                switch ($url[1]) {
                    case "recherche":
                        getEntrepriseByRecherche($url[2]);
                        break;
                    default:
                        throw new Exception("La demande pour 'entreprise' n'est pas valide.");
                }
                break;
                case "stats":
                    if (!isset($url[1])) {
                        throw new Exception("La demande pour 'stats' n'est pas spécifiée.");
                    }
                    switch ($url[1]) {
                        case "secteur":
                            getStatsBySecteur();
                            break;
                        case "ville":
                            getStatsByVille();
                            break;
                        case "note":
                            getStatsByNote();
                            break;
                        default:
                            throw new Exception("La demande pour 'stats' n'est pas valide.");
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