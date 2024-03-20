<?php

class SessionManager extends Controller{

    public function startSession($id, $type, $lastName, $firstName, $promo){

        session_start();
        $_SESSION['userData'] = [ 'id' => $id,
                                'type' => $type,
                                'firstName' => $firstName,
                                'lastName' => $lastName, 
                                'promo' => $promo];

    }

}