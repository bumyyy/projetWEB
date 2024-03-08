<?php

if (!empty($_POST['mail']) && !empty($_POST['mdp'])) {
    
    $mailEncoded = urlencode($_POST['mail']);
    $mdpEncoded = urlencode($_POST['mdp']);
    $isSame = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=authentification/{$mailEncoded}/{$mdpEncoded}" ));
    $utilisateur = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=utilisateur/{$mailEncoded}" ));


    if ($isSame->success) {
        // Le mail et le mot de passe correspondent
        $token = bin2hex(openssl_random_pseudo_bytes(16)); // Génère un token sécurisé
        $expire = time() + (10 * 60);
        $path = '/'; //Accesssible dans tout le domaine
        $domain = 'stagetier.fr';
        $secure = false; //  Si mis à true, le cookie ne sera envoyé que sur une connexion sécurisée (HTTPS).
        $httponly = false; //Si mis à true, le cookie ne sera accessible que par le protocole HTTP.
        $UserType = $utilisateur->type_;

        // Création d'un tableau avec les informations à stocker
        $data = [
            'token' => $token,
            'utilisateur' => $UserType
        ];

        // Conversion du tableau en chaîne JSON
        $jsonData = json_encode($data);

        setcookie("CookieSession", $token, $expire, $path, $domain, $secure, $httponly);

        header("Location: http://stagetier.fr/accueil"); // Redirigez vers la page souhaitée
    } 
    else {
        // Le mail ou le mot de passe ne correspondent pas
        header("Location: http://stagetier.fr?error=invalid"); // Redirigez vers la page de login avec un paramètre d'erreur
    }
} else {
    // Les champs mail et mot de passe ne sont pas remplis
    header("Location: http://stagetier.fr?error=emptyfields");
}