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

    public function combox($field){

        $this->loadModel('Combox');
        $this->Combox->$field();
    
    }

    public function company($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = ""){

        $this->loadModel('Company');

        switch ($action) {

            case 'allCompany':
                $this->Company->$action();
                break;

            case 'companyBySearch':
                $this->Company->$action($field1);
                break;

            case 'addCompany':
                $this->Company->$action($field1, $field2, $field3, $field4);
                break;

            case 'editCompany':
                //a faire
                break;

            case 'deleteCompany':
                $this->Company->$action($field1);
                break;
            
            default:
                echo "Action for 'company' not define";
                break;
        }

    }

}