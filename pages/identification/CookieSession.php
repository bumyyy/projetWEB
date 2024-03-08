<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use App\UserSessionManager;

// Création d'une instance de UserSessionManager
$sessionManager = new UserSessionManager();

// À placer au début de chaque script qui nécessite une vérification de session
//$sessionManager->verifySession();

$sessionManager->startSession(bin2hex(openssl_random_pseudo_bytes(16)), dataResponse.type_); // Générer un token sécurisé

?>
