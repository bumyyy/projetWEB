<?php

class Accueil extends Controller {
    
    public function index(){
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['utilisateur' => $_SESSION['userData']['type']]);
            } else {
                header('Location: http://stagetier.fr/login/');
                exit(0);
            }
    }


}