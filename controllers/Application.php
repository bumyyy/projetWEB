<?php

class Application extends Controller{
    
    public function index(){
        $this->render('index');
    }

    public function apply($idCompany){
        $this->render('apply', ['idCompany' => $idCompany]);
    }

}