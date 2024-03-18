<?php

class Company extends Controller{
    
    public function index(){
        $this->render('index');
    }

    public function create(){
        $this->render('create');
    }
}