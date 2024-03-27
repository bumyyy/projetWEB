<?php

class Pilot extends Controller{
    
    public function index(){
        if ( isset($_SESSION['userData'])) {
            $this->render('index');
            } else {
                header('Location: https://stagetier.fr/login/');
                exit(0);
            }
    }

    public function create(){
        if ( isset($_SESSION['userData'])) {
            $this->render('create');
            } else {
                header('Location: https://stagetier.fr/login/');
                exit(0);
            }
    }

    public function edit(){
        if ( isset($_SESSION['userData'])) {
            $this->render('edit');
            } else {
                header('Location: https://stagetier.fr/login/');
                exit(0);
            }
    }

    public function stats(){
        if ( isset($_SESSION['userData'])) {
            $this->render('stats');
            } else {
                header('Location: https://stagetier.fr/login/');
                exit(0);
            }
    }
}