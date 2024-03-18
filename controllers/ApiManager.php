<?php

class ApiManager extends Controller{

    public function login($mail, $password){

        $this->loadModel('Password');
        $this->Password->isPassword(urldecode($mail), $password);

    }

    public function user($mail){

        $this->loadModel('User');
        $this->User->getUserByMail(urldecode($mail));
        
    }

}