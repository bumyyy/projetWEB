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
            return $data->userType;
        }
        return false;
    }

    public function getUserFirstName() {
        if(isset($_COOKIE['CookieSession'])) {
            $cookie = urldecode($_COOKIE['CookieSession']);
            $data = json_decode($cookie);
            return $data->userFirstName;
        }
        return false;
    }

    public function getUserLastName() {
        if(isset($_COOKIE['CookieSession'])) {
            $cookie = urldecode($_COOKIE['CookieSession']);
            $data = json_decode($cookie);
            return $data->userLastName;
        }
        return false;
    }

    public function getUserPromo() {
        if(isset($_COOKIE['CookieSession'])) {
            $cookie = urldecode($_COOKIE['CookieSession']);
            $data = json_decode($cookie);
            return $data->userPromo;
        }
        return false;
    }

    // Méthode pour démarrer une session avec un cookie
    public function startSession($token, $userType, $userFirstName, $userLastName, $userPromo, $expire = 600, $path = '/', $domain = 'stagetier.fr', $secure = false, $httponly = false) {
        
        // Création d'un tableau avec les informations à stocker
        $data = [
            'token' => $token,
            'userType' => $userType,
            'userFirstName' => $userFirstName,
            'userLastName' => $userLastName,
            'userPromo' => $userPromo
        ];

        // Conversion du tableau en chaîne JSON
        $jsonData = json_encode($data);
        setcookie($this->cookieName, $jsonData, time() + $expire, $path, $domain, $secure, $httponly);
        // Vous pouvez également initialiser la session PHP ici si nécessaire
    }
}
