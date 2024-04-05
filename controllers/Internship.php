<?php

class Internship extends Controller {

    public function index($companyName = "") {
        $active_page = "internship";
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['companyName' => $companyName, 'active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }

    public function create() {
        $active_page = "internship";
        if ( !isset($_SESSION['userData']) ){
            header('Location: /login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('create', ['active_page' => $active_page]);
        }
    }

    public function edit($idCompany ) {
        $active_page = "internship";
        if ( !isset($_SESSION['userData']) ){
            header('Location: /login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('edit' , ['idCompany' => $idCompany, 'active_page' => $active_page]);
        }
    }
    public function stats() {
        $active_page = "internship";
        if ( !isset($_SESSION['userData']) ){
            header('Location: /login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 3 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('stats', ['active_page' => $active_page]);
        }
    }
}