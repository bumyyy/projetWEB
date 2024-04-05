<?php

class Application extends Controller{
    
    public function index(){
        $active_page = "application";
        if ( isset($_SESSION['userData'])) {
            $this->render('index', ['active_page' => $active_page]);
            } else {
                header('Location: /login/');
                exit(0);
            }
    }

    public function apply($idCompany){
        $active_page = "application";
        if ( !isset($_SESSION['userData']) ){
            header('Location: /login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 2 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('apply' , ['idCompany' => $idCompany, 'active_page' => $active_page]);
        }
    }

}