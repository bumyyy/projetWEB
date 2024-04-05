<?php

class Company extends Controller{
    
    public function index(){
        $active_page = "company";
        if ( isset($_SESSION['userData'])) {
        $this->render('index', ['active_page' => $active_page]);
        } else {
            header('Location: /login/');
            exit(0);
        }
    }

    public function create(){    
        $active_page = "company"; 
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

    public function edit($idCompany){
        $active_page = "company";
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

    public function stats(){
        $active_page = "company";
        if ( isset($_SESSION['userData'])) {
            $this->render('stats', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }
}