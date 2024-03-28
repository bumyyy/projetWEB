<?php

class Internship extends Controller {

    public function index($companyName = "") {
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['companyName' => $companyName]);
            } else {
                header('Location: http://stagetier.fr/login/');
                exit(0);
            }
    }

    public function create() {
        if ( !isset($_SESSION['userData']) ){
            header('Location: http://stagetier.fr/login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('create');
        }
    }

    public function edit($idCompany ) {
        if ( !isset($_SESSION['userData']) ){
            header('Location: http://stagetier.fr/login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('edit' , ['idCompany' => $idCompany]);
        }
    }
    public function stats() {
        if ( !isset($_SESSION['userData']) ){
            header('Location: http://stagetier.fr/login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('stats');
        }
    }
}