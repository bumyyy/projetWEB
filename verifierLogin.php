<?php

if (!empty($_POST['mail']) && !empty($_POST['mdp'])) {
    
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];
    $isSame = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=authentification/" . urlencode($mail) . "/" . urlencode($mdp)));
    print_r($mail);
    if ($isSame) {
        // Le mail et le mot de passe correspondent
        //header("Location :http://stagetier.fr/accueil"); // Redirigez vers la page souhaitée
    } 
    else {
        // Le mail ou le mot de passe ne correspondent pas
        //header("Location: http://stagetier.fr?error=invalid"); // Redirigez vers la page de login avec un paramètre d'erreur
    }
} else {
    // Les champs mail et mot de passe ne sont pas remplis
    //header("Location: http://stagetier.fr?error=emptyfields");
}

