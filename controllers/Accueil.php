<?php

class Accueil extends Controller {
    
    public function index(){
        if ( isset($_SESSION['userData'])) {
            $this->render('index');
            } else {
                header('Location: http://stagetier.fr/login/');
                exit(0);
            }
    }


}