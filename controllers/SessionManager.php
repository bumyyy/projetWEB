<?php

class SessionManager extends Controller{

    public function startSession($id, $type, $lastName, $firstName, $promo){

        session_start();
        $_SESSION['userData'] = [ 'id' => $id,
                                'type' => $type,
                                'firstName' => $firstName,
                                'lastName' => $lastName, 
                                'promo' => $promo];

    }

    public function logout() {
        // Détruisez la session ou supprimez les éléments nécessaires
        session_destroy(); // Cela détruit toutes les données associées à la session actuelle
    
        header('location:https://stagetier.fr/accueil/');
    }


}