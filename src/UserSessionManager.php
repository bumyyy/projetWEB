<?php

namespace App;

class UserSessionManager {
    private $redirectUrlOnFail;
    private $cookieName;

    public function __construct($cookieName = 'CookieSession', $redirectUrlOnFail = 'http://stagetier.fr/pages/identification') {
        $this->cookieName = $cookieName;
        $this->redirectUrlOnFail = $redirectUrlOnFail;
    }

    public function verifySession() {
        if (!isset($_COOKIE[$this->cookieName])) {
            header("Location: {$this->redirectUrlOnFail}");
            exit;
        }

    }

    public function getUserType() {
        if(isset($_COOKIE['CookieSession'])) {
            $cookie = urldecode($_COOKIE['CookieSession']);
            $data = json_decode($cookie);
            return $data->utilisateur;
        }
        return false;
    }

    // Méthode pour démarrer une session avec un cookie
    public function startSession($token, $userType, $expire = 600, $path = '/', $domain = 'stagetier.fr', $secure = false, $httponly = false) {
        
        // Création d'un tableau avec les informations à stocker
        $data = [
            'token' => $token,
            'utilisateur' => $userType
        ];

        // Conversion du tableau en chaîne JSON
        $jsonData = json_encode($data);
        setcookie($this->cookieName, $jsonData, time() + $expire, $path, $domain, $secure, $httponly);
        // Vous pouvez également initialiser la session PHP ici si nécessaire
    }
}
