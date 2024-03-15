<?php
require_once("./requete.php");
include_once 'Query.php';

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        
        switch ($url[0]) {
            case "authentification":
                $password = new Password();
                $password->isPassword(urldecode($url[1]), $url[2]); // urldecode pour transformer le %40 en @               
                break;
            case "utilisateur":
                getUtilisateur(urldecode($url[1]));
                break;
            case "combox":
                if (!isset($url[1])) {
                    throw new Exception("La demande pour 'combox' n'est pas spécifiée.");
                    break;
                }
                $combox = new Combox();
                switch ($url[1]) {
                    case "secteur":
                        $combox->secteur();
                        break;
                    case "ville":
                        $combox->ville();
                        break;
                    case "note":
                        $combox->note();
                        break;
                    default:
                        throw new Exception("La demande pour 'combox' n'est pas valide.");
                }
                break;
            case "entreprise":
                $company = new Company();
                if (!isset($url[1])) {
                    $company->allCompany();
                    break;
                }
                switch ($url[1]) {
                    case "recherche":
                        $company->companyBySearch($url[2]);
                        break;
                    case "creer":
                        $company->addCompany($url[2], $url[3], $url[4], $url[5]);
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
                case "supprimer":
                    if (!isset($url[1])) {
                        throw new Exception("La demande pour 'supprimer' n'est pas spécifiée.");
                    }
                    switch ($url[1]) {
                        case "entreprise":
                            deleteEntreprise($url[2]);
                            break;
                        case "ville":
                            
                            break;
                        case "note":
                            
                            break;
                        default:
                            throw new Exception("La demande pour 'supprimer' n'est pas valide.");
                    }
                    break;
                case "ajouter":
                    if (!isset($url[1])) {
                        throw new Exception("La demande pour 'ajouter' n'est pas spécifiée.");
                    }
                    switch ($url[1]) {
                        case "entreprise":
                            addCompany($url[2], $url[3], $url[4], $url[5]);
                            break;
                        case "ville":
                            
                            break;
                        case "note":
                            
                            break;
                        default:
                            throw new Exception("La demande pour 'supprimer' n'est pas valide.");
                    }
                    break;

            case "stage":
                if (!isset($url[1])) {
                    getStage();
                    break;
                } else {
                    switch ($url[1]) {
                        case "recherche":
                            getStageRecherche($url[2]);
                            break;
                        default:
                            throw new Exception("La demande pour 'stage' n'est pas valide.");
                    }
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