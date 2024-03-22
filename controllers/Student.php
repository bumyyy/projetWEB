<?php

class Student extends Controller{
    
    public function index(){
        $this->render('index');
    }

    public function create(){
        $this->render('create');
    }

    public function edit($idCompany){
        $this->render('edit', ['idCompany' => $idCompany]);
    }

    public function stats(){
        $this->render('stats');
    }
}