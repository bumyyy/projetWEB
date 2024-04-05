<?php

class Accueil extends Controller {
    
    public function index(){
        $active_page = "accueil";
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }


}