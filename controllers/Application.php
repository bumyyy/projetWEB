<?php

class Application extends Controller{
    
    public function index(){
        if ( isset($_SESSION['userData'])) {
            $this->render('index');
            } else {
                header('Location: https://stagetier.fr/login/');
                exit(0);
            }
    }

    public function apply($idCompany){
        if ( !isset($_SESSION['userData']) ){
            header('Location: https://stagetier.fr/login/');
            exit(0);
        }
        if ( $_SESSION['userData']['type'] == 2 ){
            echo 'Vous ne pouvez pas acceder à cette page';
        }
        else {
            $this->render('apply' , ['idCompany' => $idCompany]);
        }
    }

}