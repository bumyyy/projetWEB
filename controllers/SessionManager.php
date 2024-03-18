<?php

class SessionManager extends Controller{

    public function startSession($id){

        session_start();
        $_SESSION['userId'] = $id;
        echo 'ca fonctionne'; exit; 
    }
}