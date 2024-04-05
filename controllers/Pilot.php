<?php

class Pilot extends Controller{
    
    public function index(){
        $active_page = "pilot";
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }

    public function create(){
        $active_page = "pilot";
        if ( isset($_SESSION['userData'])) {
            $this->render('create', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }

    public function edit(){
        $active_page = "pilot";
        if ( isset($_SESSION['userData'])) {
            $this->render('edit', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }

    public function stats(){
        $active_page = "pilot";
        if ( isset($_SESSION['userData'])) {
            $this->render('stats', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }
}