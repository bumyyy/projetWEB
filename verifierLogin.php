<?php

if (!empty($_POST['mail']) && !empty($_POST['mdp'])) {
    
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];
    $vrai_mdp = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=authentification/" . urlencode($mail)));
    
    if ($vrai_mdp[0]->mdp == $mdp) {
        // Le mail et le mot de passe correspondent
        header(Location :"http://stagetier.fr/accueil"); // Redirigez vers la page souhaitée
    } 
} else {
    // Les champs mail et mot de passe ne sont pas remplis
    header("Location: votrePage.php?error=emptyfields");
}
