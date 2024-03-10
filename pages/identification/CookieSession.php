<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use App\UserSessionManager;

// Récupération du corps de la requête POST et décodage du JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true); // true pour obtenir un tableau associatif

// Vérifier que data contient bien la clé 'typeUtilisateur'
if (isset($data['typeUtilisateur'])) {
    $typeUtilisateur = $data['typeUtilisateur'];

    // Création d'une instance de UserSessionManager
    $sessionManager = new UserSessionManager();

    // Démarrer une session avec le type d'utilisateur
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $sessionManager->startSession($token, $typeUtilisateur);

} 


