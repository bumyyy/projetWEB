<?php

class Accueil extends Controller {
    
    public function index(){
        if ( isset($_SESSION['userData'])) {
            $this->render('index');
            } else {
                header('Location: /login/');
                exit(0);
            }
    }


}