<?php

class Student extends Controller{
    
    public function index(){
        $this->render('index');
    }

    public function create(){
        $this->render('create');
    }

    public function edit(){
        $this->render('edit');
    }

    public function stats(){
        $this->render('stats');
    }
}