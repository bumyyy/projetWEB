<?php
include_once 'Query.php';

try {
    if (!empty($_GET['demande'])) {
        $url = explode('/', filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        
        switch ($url[0]) {
            case "authentication":
                $password = new Password();
                $password->isPassword(urldecode($url[1]), $url[2]); // urldecode pour transformer le %40 en @               
                break;
            case "user":
                $user = new User();
                $user->getUserByMail($url[1]);
                break;
            case "combox":
                if (!isset($url[1])) {
                    throw new Exception("La demande pour 'combox' n'est pas spécifiée.");
                    break;
                }
                $combox = new Combox();
                switch ($url[1]) {
                    case "sector":
                        $combox->sector();
                        break;
                    case "city":
                        $combox->city();
                        break;
                    case "rate":
                        $combox->rate();
                        break;
                    default:
                        throw new Exception("La demande pour 'combox' n'est pas valide.");
                }
                break;
            case "company":
                $company = new Company();
                if (!isset($url[1])) {
                    $company->allCompany();
                    break;
                }
                switch ($url[1]) {
                    case "search":
                        $company->companyBySearch($url[2]);
                        break;
                    case "create":
                        $company->addCompany($url[2], $url[3], $url[4], $url[5]);
                        break;
                    case "edit":
                        $company->editCompany();
                    case "delete":
                        $company->deleteCompany($url[2]);
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