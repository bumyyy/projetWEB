<?php

class Accueil extends Controller {
    
    public function index(){
        //$this->loadModel('User');
        //$user = $this->User->getUserByMail('carla.barde@email.com');

        $this->render('index');
    }

    public function lire($id){
        echo $id;
    }
}