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

    public function company($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = ""){

        $this->loadModel('Company');

        switch ($action) {

            case 'allCompany':
                $this->Company->$action();
                break;

            case 'companyBySearch':
                $this->Company->$action($field1);
                break;

            case 'selectCompany':
                $this->Company->$action($field1);
                break;

            case 'addCompany':
                $this->Company->$action($field1, $field2, $field3, $field4, $field5);
                break;

            case 'editCompany':
                $this->Company->$action($field1, $field2, $field3, $field4, $field5);
                break;

            case 'deleteCompany':
                $this->Company->$action($field1);
                break;
            
            case 'statSector':
                $this->Company->$action();
                break;

            case 'statCity':
                $this->Company->$action();
                break;

            case 'statop3':
                $this->Company->$action();
                break;
                
            default:
                echo "Action for 'company' not define";
                break;
        }

    }

    public function pilot($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = ""){

        $this->loadModel('Pilot');

        switch ($action) {

            case 'allPilot':
                $this->Pilot->$action();
                break;

            case 'pilotBySearch':
                $this->Pilot->$action($field1);
                break;

            case 'selectPilot':
                $this->Pilot->$action($field1);
                break;
            
            default:
                echo "Action for 'pilot' not define";
                break;
        }

    }

}